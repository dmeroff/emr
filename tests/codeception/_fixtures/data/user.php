<?php

use Faker\Factory;
use yii\db\Expression;

$faker = Factory::create();
$hash  = Yii::$app->security->generatePasswordHash('qwerty', 4);

return [
    'user' => [
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
];
