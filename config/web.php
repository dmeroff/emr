<?php

use app\modules\emr\EmrModule;
use app\modules\organization\OrganizationModule;
use app\modules\user\UserModule;

$config = [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'modules' => [
        'user'         => UserModule::class,
        'emr'          => EmrModule::class,
        'organization' => OrganizationModule::class,
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

                // emr module
                'POST tests' => 'emr/test/create',
                'GET tests' => 'emr/test/index',
                'GET tests/<id:\d+>' => 'emr/test/index',
                'POST biosignals' => 'emr/biosignal/create',
                'GET patients' => 'emr/patient/index',
                'GET patients/<id:\d+>' => 'emr/patient/view',
                'PUT patients/<id:\d+>' => 'emr/patient/update',
                'DELETE patients/<id:\d+>' => 'emr/patient/delete',

                // organization module
                'GET organizations' => 'organization/organization/view',
                'PUT organizations' => 'organization/organization/update',

                'GET organization-archives' => 'organization-archive/index',
                'GET organization-archives/<id:\d+>/revision/<revision:\d+>' => 'organization-archive/view',
                'GET patient-archives' => 'patient-archive/index',
                'GET patient-archives/<id:\d+>/revision/<revision:\d+>' => 'patient-archive/view',
            ],
        ],
    ],
];

return $config;
