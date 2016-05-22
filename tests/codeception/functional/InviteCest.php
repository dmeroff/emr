<?php

use app\modules\user\models\User;
use app\modules\user\models\UserInvite;
use Faker\Factory;
use yii\helpers\Json;

class InviteCest
{
    public function testInviteCreate(FunctionalTester $I)
    {
        $faker  = Factory::create();
        $email  = $faker->email;
        $token  = $I->getTokenFixture('doctor_auth_token')->code;
        $doctor = $I->getUserFixture('doctor');

        $I->amHttpAuthenticated($token, '');
        $I->sendPOST('invites', ['email' => $email, 'role' => User::ROLE_PATIENT]);

        // verify that invite is created
        $invite = UserInvite::find()->byEmail($email)->byReferrerId($doctor->id)->one();
        verify($invite)->notNull();

        // verify that response contains invite code
        $I->seeResponseCodeIs(201);
        $I->seeResponseContains($invite->code);

        // verify that there is only one invite with this code
        $count = UserInvite::find()->byCode($invite->code)->count();
        verify($count)->equals(1);
    }

    public function testInviteList(FunctionalTester $I)
    {
        $token = $I->getTokenFixture('doctor_auth_token')->code;

        $I->amHttpAuthenticated($token, '');
        $I->sendGET('invites');
        $I->canSeeResponseCodeIs(200);
        
        $response = Json::decode($I->grabResponse());
        $invite1  = $I->getInviteFixture('patient_invite');
        $invite2  = $I->getInviteFixture('patient2_invite');

        verify(count($response))->equals(2);
        verify($response[0]['email'])->equals($invite1->email);
        verify($response[1]['email'])->equals($invite2->email);
    }

    public function testInviteView(FunctionalTester $I)
    {
        $token  = $I->getTokenFixture('doctor_auth_token')->code;
        $invite = $I->getInviteFixture('patient_invite');

        $I->amHttpAuthenticated($token, '');
        $I->sendGET('invites/' . $invite->id);
        $I->canSeeResponseCodeIs(200);

        $response = Json::decode($I->grabResponse());

        verify($response['email'])->equals($invite->email);
    }
}
