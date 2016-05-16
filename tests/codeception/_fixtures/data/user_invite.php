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
    'doctor_invite' => [
        'email'       => $faker->email,
        'code'        => '9876543210',
        'created_at'  => new Expression('NOW()'),
        'role'        => User::ROLE_DOCTOR,
        'referrer_id' => 3,
    ],
    'patient_invite' => [
        'email'       => $faker->email,
        'code'        => '03324569877',
        'created_at'  => new Expression('NOW()'),
        'role'        => User::ROLE_PATIENT,
        'referrer_id' => 2,
    ],
];
