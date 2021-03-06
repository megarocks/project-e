<?php

    $params = require(__DIR__ . '/params.php');

    $config = [
        'id' => 'endymed-ppd-web',
        'basePath'   => dirname(__DIR__),
        'bootstrap'  => ['log'],
        'components' => [
            'view'         => [
                'theme' => [
                    'pathMap' => [
                        '@app/views'   => '@app/themes/ace',
                        '@app/modules' => '@app/themes/ace/modules',
                        '@app/widgets' => '@app/themes/ace/widgets',
                    ],
                ],
            ],
            'request'      => [
                // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
                'cookieValidationKey' => '95NBmEDcQfBHMua9RNRTSnuvQYkV2h7w',
                'parsers'             => [
                    'application/json' => 'yii\web\JsonParser',
                ]
            ],
            'cache'        => [
                'class' => 'yii\caching\FileCache',
            ],
            'user'         => [
                'identityClass'   => 'app\models\User',
                'enableAutoLogin' => true,
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            'mailer'       => [
                'class'     => 'yii\swiftmailer\Mailer',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                //'useFileTransport' => true,
                'transport' => [
                    'class'      => 'Swift_SmtpTransport',
                    'host'       => 'smtp.gmail.com',
                    'username'   => 'bdevelopers.key@gmail.com',
                    'password'   => 'bohbohboh',
                    'port'       => '465',
                    'encryption' => 'ssl',
                ],
            ],
            'log'          => [
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets'    => [
                    [
                        'class'       => 'yii\log\FileTarget',
                        'levels'      => ['error', 'warning'],
                        'maxFileSize' => '10240',
                    ],
                    [
                        'class'       => 'yii\log\FileTarget',
                        'categories'  => ['paypal'],
                        'logVars'     => [],
                        'levels'      => ['info', 'error', 'warning'],
                        'logFile'     => '@runtime/logs/paypal.log',
                        'maxFileSize' => '10240',
                    ],
                    [
                        'class'       => 'yii\log\FileTarget',
                        'categories'  => ['login', 'logout'],
                        'logVars'     => [],
                        'levels'      => ['info', 'error', 'warning'],
                        'logFile'     => '@runtime/logs/login.log',
                        'maxFileSize' => '10240',
                    ],
                ],
            ],
            'db'           => require(__DIR__ . '/db.php'),
            'urlManager'   => [
                'enablePrettyUrl' => true,
                'showScriptName'  => false,
                'rules'           => [
                    '<controller>/<id:\d+>'          => '<controller>/view',
                    '<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                    '<controller>/<action:\w+>'      => '<controller>/<action>',
                ],
            ],
            'authManager'  => [
                'class' => 'yii\rbac\DbManager'
            ],
        ],
        'params'     => $params,
    ];

    if (YII_ENV_DEV) {
        // configuration adjustments for 'dev' environment
        /*    $config['bootstrap'][] = 'debug';
            $config['modules']['debug'] = 'yii\debug\Module';*/

        $config['bootstrap'][] = 'gii';
        $config['modules']['gii'] = 'yii\gii\Module';
    }

    return $config;
