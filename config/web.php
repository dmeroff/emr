<?php

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
        ],
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
                ['class' => 'yii\rest\UrlRule', 'controller' => 'organization-archive', 'only' => ['index', 'view'],
                    'prefix' => '/revision/<revision:\\d+>',
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                    'patterns' => [
                        'GET' => 'index',
                        'GET {id}' => 'view',
                    ]],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'patient-archive', 'only' => ['index', 'view'],
                    'prefix' => '/revision/<revision:\\d+>',
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                    ],
                    'patterns' => [
                        'GET' => 'index',
                        'GET {id}' => 'view',
                    ]],
            ],
        ],
    ],
];

return $config;
