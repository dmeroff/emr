<?php

use app\modules\user\UserModule;

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'modules' => [
        'user' => UserModule::class,
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => 'json'
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                // user module
                'POST users' => 'user/user/create',
                'POST tokens' => 'user/token/create',
                'DELETE tokens' => 'user/token/delete',
                'POST invites' => 'user/invite/create',
                'GET invites' => 'user/invite/index',
                'GET invites/<id:\d+>' => 'user/invite/view',
                'POST recovery' => 'user/recovery/request',
                'PUT user/password' => 'user/recovery/recover',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'test', 'only' => ['create', 'index'], 'patterns' => [
                    'GET,HEAD {id}' => 'index',
                    'POST'          => 'create',
                    'GET,HEAD'      => 'index',
                ]],
                'GET organizations' => 'organization/view',
                'PUT organizations' => 'organization/update',
                'POST biosignals' => 'biosignal/create',
                'GET organization-archives' => 'organization-archive/index',
                'GET organization-archives/<id:\d+>/revision/<revision:\d+>' => 'organization-archive/view',
                'GET patient-archives' => 'patient-archive/index',
                'GET patient-archives/<id:\d+>/revision/<revision:\d+>' => 'patient-archive/view',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'patient', 'only' => ['index', 'update', 'view', 'delete']],
            ],
        ],
    ],
];

return $config;
