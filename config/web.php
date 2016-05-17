<?php

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
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
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user', 'only' => ['create']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'invite', 'only' => ['create', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'token', 'only' => ['create', 'delete'], 'patterns' => [
                    'DELETE' => 'delete',
                    'POST'   => 'create',
                ]],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'organization', 'only' => ['create', 'index', 'update', 'view']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'test', 'only' => ['create']],
                'POST recovery' => 'recovery/request',
                'PUT user/password' => 'recovery/recover',
                'GET organization-archives' => 'organization-archive/index',
                'GET organization-archives/<id:\d+>/revision/<revision:\d+>' => 'organization-archive/view',
                'GET patient-archives' => 'patient-archive/index',
                'GET patient-archives/<id:\d+>/revision/<revision:\d+>' => 'patient-archive/view',
            ],
        ],
    ],
];

return $config;
