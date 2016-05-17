<?php

use yii\db\Expression;
use yii\helpers\Json;

return [
    [
        'id' => 1,
        'patient_id' => 1,
        'created_at' => '2016-05-17 17:00:00',
        'data' => Json::encode([
            'question1' => [
                'result' => 5,
            ],
            'question2' => [
                'result' => 3,
            ],
            'question3' => [
                'result' => 4,
            ],
        ]),
    ],
    [
        'id' => 2,
        'patient_id' => 1,
        'created_at' => '2016-05-17 18:00:00',
        'data' => Json::encode([
            'question1' => [
                'result' => 3,
            ],
            'question2' => [
                'result' => 2,
            ],
            'question3' => [
                'result' => 1,
            ],
        ]),
    ],
    [
        'id' => 3,
        'patient_id' => 2,
        'created_at' => '2016-05-17 19:00:00',
        'data' => Json::encode([
            'question1' => [
                'result' => 0,
            ],
            'question2' => [
                'result' => 5,
            ],
            'question3' => [
                'result' => 2,
            ],
        ]),
    ],
];
