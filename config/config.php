<?php
$config = [
    'id' => 'basic',
    'name' => 'Курсы',
    'basePath' => dirname(__DIR__),
    'extensions' => require __DIR__ . '/../vendor/yiisoft/extensions.php',
    'aliases' => [
        '@app' => dirname(__DIR__),
        '@webroot' => '@app/web',
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'assetManager' => [
            'baseUrl' => '/assets',
            'basePath' => '@webroot/assets',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'contactform' => [
            'class' => 'app\models\ContactForm'
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'xxxxxxx',
        ],
        'viewPath' => dirname(__DIR__) . '/views',
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'user'=>array(
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ),
        'log' => [
            'class' => 'yii\log\Dispatcher',
            'levels' => ['error'],
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                ],
            ],
        ],
        'db' => require (__DIR__ . '/db.php'),
        'urlManager' => array(
            'rules' => [
                '<controller:\w+>/<action:\w+>' => '<controller>/index',
            ],
        ),
    ]
];
return $config;