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
                            'actions' => ['index', 'logout', 'password-reset', 'error'],
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

        public function actionLogin($visibleForm = 'credentials')
        {
            if (!\Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            $credentialsLoginForm = new CredentialsLoginForm();
            $codeLoginForm = new CodeLoginForm();
            $forgotPasswordForm = new ForgotPasswordForm();

            $request = Yii::$app->request->post();
            if ($visibleForm == 'credentials' && $credentialsLoginForm->load($request) && $credentialsLoginForm->login()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Congrats! You`re logged in successfully'), false);
                Yii::$app->session->setFlash('warning', Yii::t('app', 'Congrats! You`re logged in successfully'), false);
                Yii::$app->session->setFlash('info', Yii::t('app', 'Congrats! You`re logged in successfully'), false);

                return $this->goBack();
            } elseif ($visibleForm == 'code' && $codeLoginForm->load($request) && $codeLoginForm->login()) {
                Yii::$app->session->set('loginCode', $codeLoginForm->loginCode);

                return $this->redirect('/system/view-by-code');
            } elseif ($visibleForm == 'forgot' && $forgotPasswordForm->load($request) && $forgotPasswordForm->validate()) {
                $forgotPasswordForm->sendMailWithLink();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check your mailbox for instructions'));

                return $this->refresh();
            } else {
                return $this->renderPartial('login', [
                    'credentialsLoginForm' => $credentialsLoginForm,
                    'codeLoginForm'        => $codeLoginForm,
                    'forgotPasswordForm' => $forgotPasswordForm,
                    'visibleForm'        => $visibleForm,
                ]);
            }
        }

        public function actionLogout()
        {
            Yii::$app->user->logout();

            return $this->goHome();
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
