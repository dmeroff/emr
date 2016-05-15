<?php

use app\models\Organization;
use Faker\Factory;

class OrganizationCest
{
    public function testOrganizationCreate(FunctionalTester $I)
    {
        $faker = Factory::create();
        $email = $faker->email;
        $token = $I->getTokenFixture('chief1_auth_token')->code;
        $chief = $I->getUserFixture('chief1');

        $I->amHttpAuthenticated($token, '');
        $I->sendPOST('organizations', [
            'code'                => '123456',
            'name'                => 'Имя организации',
            'address'             => 'Адрес',
            'attestat_number'     => 'Номер аттестата',
            'chief_name'          => 'Имя руководителя',
            'chief_position_name' => 'Должность руководителя',
            'chief_phone'         => '+79814027851',
            'chief_email'         => $email,
        ]);

        // verify that invite is created
        $organization = Organization::find()->byOwnerId($chief->id)->one();
        verify($organization)->notNull();

        // verify that response contains invite code
        $I->seeResponseCodeIs(201);
        verify($I->grabResponse())->equals('');
    }
}
