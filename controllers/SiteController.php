<?php

    namespace app\controllers;

    use app\models\CodeLoginForm;
    use app\models\CredentialsLoginForm;
    use app\models\ForgotPasswordForm;
    use app\models\System;
    use app\models\User;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\web\NotFoundHttpException;

    class SiteController extends Controller
    {
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'logout', 'password-reset'],
                            'allow'   => true,
                            'roles'   => ['@'],
                        ],
                        [
                            'actions' => ['login', 'login-by-code', 'forgot-password', 'password-reset'],
                            'allow'   => true,
                            'roles'   => ['?']
                        ]
                    ],
                ],
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'logout' => ['post', 'get'],
                    ],
                ],
            ];
        }

        public function actions()
        {
            return [
                'error'   => [
                    'class' => 'yii\web\ErrorAction',
                ],
                'captcha' => [
                    'class'           => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                ],
            ];
        }

        public function actionIndex()
        {
            return $this->render('index');
        }

        public function actionLogin($initForm = 'code')
        {
            if (!\Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            $credentialsLoginForm = new CredentialsLoginForm();
            $codeLoginForm = new CodeLoginForm();
            $request = Yii::$app->request->post();

            if ($credentialsLoginForm->load($request) && $credentialsLoginForm->login()) {
                return $this->goBack();
            } else {
                return $this->render('login', [
                    'credentialsLoginForm' => $credentialsLoginForm,
                    'codeLoginForm'        => $codeLoginForm,
                    'initForm'             => $initForm,
                ]);
            }
        }

        public function actionLoginByCode($initForm = 'code')
        {
            if (!\Yii::$app->user->isGuest) {
                return $this->goHome();
            }
            $codeLoginForm = new CodeLoginForm();
            $credentialsLoginForm = new CredentialsLoginForm();
            $request = Yii::$app->request->post();
            if ($codeLoginForm->load($request) && $codeLoginForm->login()) {
                Yii::$app->session->set('loginCode', $codeLoginForm->loginCode);

                return $this->redirect('/system/view-by-code');
            } else {
                return $this->render('login', [
                    'credentialsLoginForm' => $credentialsLoginForm,
                    'codeLoginForm'        => $codeLoginForm,
                    'initForm'             => $initForm,
                ]);
            }
        }

        public function actionLogout()
        {
            Yii::$app->user->logout();

            return $this->goHome();
        }

        public function actionForgotPassword()
        {
            /**@var $model ForgotPasswordForm */
            $model = new ForgotPasswordForm();

            $request = Yii::$app->request->post();

            if (!empty($request)) {
                $model->load($request);
                if ($model->validate() && $model->sendMailWithLink()) {
                    Yii::$app->session->setFlash('notice', Yii::t('app', 'Check your email to move ahead with password restoring'));

                    return $this->redirect('site/login');
                } else {
                    return $this->render('forgot-password-form', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->render('forgot-password-form', [
                    'model' => $model,
                ]);
            }
        }

        public function actionPasswordReset($password_reset_token)
        {
            $user = User::findByPasswordResetToken($password_reset_token);
            if ($user && Yii::$app->user->login($user)) {
                $user->regeneratePasswordResetToken();
                $this->redirect('user/profile');
            } else {
                throw new NotFoundHttpException;
            }
        }
    }
