<?php

use Faker\Factory;
use yii\db\Expression;

$faker = Factory::create();
$hash  = Yii::$app->security->generatePasswordHash('qwerty', 4);

return [
    'patient' => [
        'id'            => 1,
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
    'doctor' => [
        'id'            => 2,
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
    'chief1' => [
        'id'            => 3,
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
    'chief2' => [
        'id'            => 4,
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
    'patient2' => [
        'id'            => 5,
        'email'         => $faker->email,
        'password_hash' => $hash,
        'created_at'    => new Expression('NOW()'),
    ],
];
