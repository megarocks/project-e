<?php

    namespace app\controllers;

    use app\models\CodeLoginForm;
    use app\models\CredentialsLoginForm;
    use app\models\ForgotPasswordForm;
    use app\models\System;
    use app\models\User;
    use Yii;
    use yii\filters\AccessControl;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Json;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\web\ForbiddenHttpException;
    use yii\web\MethodNotAllowedHttpException;
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
                            'actions' => ['index', 'logout', 'password-reset', 'error', 'login', 'permissions-json'],
                            'allow'   => true,
                            'roles'   => ['@'],
                        ],
                        [
                            'actions' => ['login', 'login-by-code', 'forgot-password', 'password-reset', 'permissions-json'],
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
            if (Yii::$app->user->can('viewDashboard')) {
                return $this->render('index');
            } else {
                throw new ForbiddenHttpException;
            }
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
                Yii::$app->session->set('loggedByCode', false);
                return $this->goBack();
            } elseif ($visibleForm == 'code' && $codeLoginForm->load($request) && $codeLoginForm->login()) {
                $system = System::getByLoginCode($codeLoginForm->loginCode);

                Yii::$app->session->set('loginCode', $codeLoginForm->loginCode);
                Yii::$app->session->set('systemId', $system->id);
                Yii::$app->session->set('loggedByCode', true);

                return $this->redirect(['system/view', 'id' => $system->id]);
            } elseif ($visibleForm == 'forgot' && $forgotPasswordForm->load($request) && $forgotPasswordForm->validate()) {
                $forgotPasswordForm->sendMailWithLink();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Check mailbox: {email} for instructions', ['email' => $forgotPasswordForm->email]));

                return $this->refresh();
            } else {
                return $this->renderPartial('login', [
                    'credentialsLoginForm' => $credentialsLoginForm,
                    'codeLoginForm'        => $codeLoginForm,
                    'forgotPasswordForm'   => $forgotPasswordForm,
                    'visibleForm'          => $visibleForm,
                ]);
            }
        }

        public function actionLogout()
        {
            //TODO Why do I need so much values in session?
            Yii::$app->session->remove('systemId');
            Yii::$app->session->remove('loginCode');
            Yii::$app->session->remove('loggedByCode');
            Yii::$app->user->logout();

            return $this->goHome();
        }

        public function actionPasswordReset($password_reset_token)
        {
            $user = User::findByPasswordResetToken($password_reset_token);
            if ($user && Yii::$app->user->login($user)) {
                $user->regeneratePasswordResetToken();
                $this->redirect('/user/profile');
            } else {
                if (Yii::$app->user->isGuest) {
                    Yii::$app->user->logout();
                }
                Yii::$app->session->setFlash('danger', Yii::t('app', 'This password reset link is already expired'));
                $this->redirect(['/site/login']);
            }
        }

        public function actionPermissionsJson()
        {
            if (Yii::$app->request->isPost) {
                if (!Yii::$app->user->isGuest) {
                    echo Json::encode(array_keys(Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id)));
                } else {
                    echo Json::encode([]);
                }
            } else {
                throw new MethodNotAllowedHttpException;
            }
        }
    }
