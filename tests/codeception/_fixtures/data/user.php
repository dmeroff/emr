<?php

use Faker\Factory;
use yii\db\Expression;

$faker = Factory::create();
$hash  = Yii::$app->security->generatePasswordHash('qwerty', 4);

return [
    'patient' => [
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
    'doctor' => [
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
    'chief1' => [
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
    'chief2' => [
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
];
