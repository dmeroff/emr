<?php

use yii\db\Expression;

return [
    'user_auth_token' => [
        'user_id'    => 1,
        'code'       => Yii::$app->security->generateRandomString(),
        'created_at' => new Expression('NOW()'),
    ],
];
