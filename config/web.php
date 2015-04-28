<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => '06258417e0f09a15aef1bbea74e20925e4aa47fd45c2385bf7b52aff8796780b',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
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
        'db' => require(__DIR__ . '/db.php'),
        'authClientCollection' => [
          'class' => 'yii\authclient\Collection',
          'clients' => [
              'google' => [
                  'class' => 'yii\authclient\clients\GoogleOAuth',
                  'clientId' => 'google_client_id',
                  'clientSecret' => 'google_client_secret',
              ],
              'facebook' => [
                  'class' => 'yii\authclient\clients\Facebook',
                  'clientId' => '1436471209996412',
                  'clientSecret' => 'cbd9d6b104ad9e4de3d52fdf81d3f5bf',
                  'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
              ],
          ],
        ]
    ],
    'modules' => [
        'user' => [
            'class' => 'app\modules\user\Module',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
