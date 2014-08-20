<?php

namespace app\controllers;

use app\models\CodeLoginForm;
use app\models\CredentialsLoginForm;
use app\models\System;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login', 'login-by-code'],
                        'allow'   => true,
                        'roles'   => ['?']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
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

}
