<?php
//  'resources'=>__DIR__.'/../web/theme/metronic/assets',
//  'resources' => __DIR__.'/../vendor/dlds/yii2-metronic',
$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
//EADER_FIXED,
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language'   => 'es',
    'sourceLanguage' => 'en',
    'layoutPath' => '@app/themes/metronic/views/layouts',
    //'layoutPath' => '@app/views/layouts',
    'layout' => 'main',
    'components' => [
        'formatter' => [
            'dateFormat' => 'php:m/d/Y',
            'datetimeFormat' => 'php:d-M-Y H:i:s',
            'timeFormat' => 'php:H:i:s',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gUuVx5nQ4pgdKtM6S4rOSdyb236yeix7',
           // 'csrfParam'=>'csfmambermanagement'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'metronic' => [
            'class'=>'dlds\metronic\Metronic',
            'resources'=>__DIR__.'/../web/theme/metronic/theme/assets',
            'version'=>\dlds\metronic\Metronic::VERSION_1,
            'style'=>\dlds\metronic\Metronic::STYLE_SQUARE,
            'theme'=>\dlds\metronic\Metronic::THEME_DARK,
            'layoutOption'=>\dlds\metronic\Metronic::LAYOUT_FLUID,
            'headerOption'=>\dlds\metronic\Metronic::HEADER_DEFAULT,
//            'sidebarPosition'=>\dlds\metronic\Metronic::SIDEBAR_POSITION_LEFT,
//            'sidebarOption'=>\dlds\metronic\Metronic::SIDEBAR_MENU_ACCORDION,
            'footerOption'=>\dlds\metronic\Metronic::FOOTER_FIXED,  
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'i18n' => [
                'translations' => [
                    'app*' => [
                        'class' => 'yii\i18n\PhpMessageSource',
                        //'sourceLanguage' => 'en',
                        //'basePath' => '@app/messages',
                        'fileMap' => [
                            'app' => 'app.php',
                            'app/error' => 'error.php',
                        ]
                    ],
                    'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation']
                ],
            ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/metronic/views',
                    //'@app/views' => '@app/views',
                ],
            ],
        ],
        'assetManager' => [
            'basePath' => '@webroot/assets',
            'baseUrl' => '@web/assets',
            'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        '//code.jquery.com/jquery-1.12.4.min.js',  // use custom jquery   jquery-1.11.2.min.js
                    ]
                ],

                'dlds\metronic\bundles\ThemeAsset' => [
                    'addons'=>[
                        'default/login'=>[
                            'css'=>[
                                'pages/css/login-4.min.css',
                            ],
                            'js'=>[
                                'global/plugins/backstretch/jquery.backstretch.min.js',

                            ]
                        ],
                    ]
                ],
            ],
        ],
        'urlManager' => [
            // Disable r= routes
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'languages' => ['en', 'es', 'fr', 'ru'], // List all supported languages her
            'enableStrictParsing' => true,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>',
                '/' => 'site/index',
                '<language:\w+>/<controller>/<action>/<id:\d+>/<title>' => '<controller>/<action>',
                '<language:\w+>/<controller>/<id:\d+>/<title>' => '<controller>/index',
                '<language:\w+>/<controller>/<action>/<id:\d+>' => '<controller>/<action>',
                '<language:\w+>/<controller>/<action>' => '<controller>/<action>',
                '<language:\w+>/<controller>' => '<controller>',
                '<language:\w+>/'=>'site/index',
//                'about' => 'site/about',
//                'contact' => 'site/contact',
//                'login' => 'site/login',
//                'logout' => 'site/logout',
//                'captcha' => 'site/captcha',
//                'signup' => 'site/signup',
//                'request-password-reset' => 'site/request-password-reset',
//                'reset-password' => 'site/reset-password',
//                 'member' => 'member',
//                 'department' => 'department',
//                'department/create' => 'department/create'
            ],
        ],
    ],
    'as beforeRequest' => [
        'class' => 'app\components\LanguageHandler'
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '::1','192.168.1.21'],
    ];
}

return $config;
