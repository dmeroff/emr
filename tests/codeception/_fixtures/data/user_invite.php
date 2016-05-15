<?php

use app\models\User;
use Faker\Factory;
use yii\db\Expression;

$faker = Factory::create();

return [
    'chief_invite' => [
        'email'      => $faker->email,
        'code'       => '1236547890',
        'created_at' => new Expression('NOW()'),
        'role'       => User::ROLE_CHIEF,
    ],
];
