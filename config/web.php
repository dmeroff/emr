<?php

use app\modules\archive\ArchiveModule;
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
        'archive'      => ArchiveModule::class,
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
                'POST biosignaltypes' => 'emr/biosignal-type/create',
                'GET biosignaltypes' => 'emr/biosignal-type/index',
                'GET biosignaltypes/<id:\d+>' => 'emr/biosignal-type/view',
                'PUT biosignaltypes/<id:\d+>' => 'emr/biosignal-type/update',
                'GET biosignaltimestamps' => 'emr/biosignal-timestamp/index',
                'GET biosignaltimestamps/<id:\d+>' => 'emr/biosignal-timestamp/view',

                // organization module
                'GET organizations' => 'organization/organization/view',
                'PUT organizations' => 'organization/organization/update',

                // archive module
                'GET archive/organizations' => 'archive/organization/index',
                'GET archive/organizations/<id:\d+>/revision/<revision:\d+>' => 'archive/organization/view',
                'GET archive/patients' => 'archive/patient/index',
                'GET archive/patients/<id:\d+>/revision/<revision:\d+>' => 'archive/patient/view',
            ],
        ],
    ],
];

return $config;
