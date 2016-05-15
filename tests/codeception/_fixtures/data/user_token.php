<?php

use yii\db\Expression;

return [
    'patient_auth_token' => [
        'user_id'    => 1,
        'code'       => Yii::$app->security->generateRandomString(),
        'created_at' => new Expression('NOW()'),
    ],
    'doctor_auth_token' => [
        'user_id'    => 2,
        'code'       => Yii::$app->security->generateRandomString(),
        'created_at' => new Expression('NOW()'),
    ],
    'chief1_auth_token' => [
        'user_id'    => 3,
        'code'       => Yii::$app->security->generateRandomString(),
        'created_at' => new Expression('NOW()'),
    ],
    'chief2_auth_token' => [
        'user_id'    => 4,
        'code'       => Yii::$app->security->generateRandomString(),
        'created_at' => new Expression('NOW()'),
    ],
];
