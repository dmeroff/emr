<?php


use app\models\User;
use app\models\UserInvite;
use Faker\Factory;

class InviteCest
{
    public function testCreate(FunctionalTester $I)
    {
        $faker = Factory::create();
        $email = $faker->email;

        $I->getTokenFixture('user_auth_token')->code;
        $I->amHttpAuthenticated($I->getTokenFixture('user_auth_token')->code, '');
        $I->sendPOST('invites', ['email' => $email, 'role' => User::ROLE_PATIENT]);

        // verify that invite is created
        $invite = UserInvite::find()->byEmail($email)->byReferrerId(1)->one();
        verify($invite)->notNull();

        // verify that response contains invite code
        $I->seeResponseCodeIs(201);
        $I->seeResponseContains($invite->code);

        // verify that there is only one invite with this code
        $count = UserInvite::find()->byCode($invite->code)->count();
        verify($count)->equals(1);
    }
}
