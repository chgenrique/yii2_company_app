<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name'=> 'Company Backend',
//    'defaultRoute' => 'user/index',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
//    'layoutPath' => '@app/themes/metronic/views/layouts',
//    'layoutPath' => '@app/vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app/layouts',
    'layoutPath' => '@app/themes/adminlte/views/layouts',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'jCes-ibU1BiFszb-4aFtesryyPuA3Z-r',
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
        'view' => [
//            'layout' => 'main.php'   @vendor\dmstr
            'theme' => [
                    'pathMap' => [
                        '@app/views' => 'dmstr\yii2-adminlte-asset\example-views\yiisoft\yii2-app'
                    ]
                ]
               
        ],
        'metronic'=>[
            'class'=>'dlds\metronic\Metronic',
//            'resources'=>__DIR__. '/web/metronic/assets/theme/assets',
            'style'=>\dlds\metronic\Metronic::STYLE_MATERIAL,
            'theme'=>\dlds\metronic\Metronic::THEME_LIGHT,
            'layoutOption'=>\dlds\metronic\Metronic::LAYOUT_FLUID,
            'headerOption'=>\dlds\metronic\Metronic::HEADER_FIXED,
            'sidebarPosition'=>\dlds\metronic\Metronic::SIDEBAR_POSITION_LEFT,
            'sidebarOption'=>\dlds\metronic\Metronic::SIDEBAR_MENU_ACCORDION,
            'footerOption'=>\dlds\metronic\Metronic::FOOTER_FIXED,
            ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [ 'app' => 'app.php', ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        /*'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<action:\w+>' => 'site/<action>',
                '<controller:\w+/?>' => '<controller>/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],*/
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
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
