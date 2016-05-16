<?php

use app\models\User;
use app\models\UserToken;

class RegistrationCest
{
    public function testChiefRegister(FunctionalTester $I)
    {
        $invite = $I->getInviteFixture('chief_invite');

        $I->sendPOST('users', [
            'email'      => $invite->email,
            'password'   => 'qwerty',
            'inviteCode' => $invite->code,
        ]);
        $code  = trim($I->grabResponse(), '"');
        $I->canSeeResponseCodeIs(201);

        $user = User::find()->byEmail($invite->email)->one();
        verify($user)->notNull();
        verify(Yii::$app->authManager->checkAccess($user->id, User::ROLE_CHIEF));
        verify($user->patient)->null();

        $token = UserToken::find()->byUserId($user->id)->byCode($code)->one();
        verify($token)->notNull();
    }

    public function testPatientRegister(FunctionalTester $I)
    {
        $invite = $I->getInviteFixture('patient_invite');

        $I->sendPOST('users', [
            'email'      => $invite->email,
            'password'   => 'qwerty',
            'inviteCode' => $invite->code,
        ]);
        $code  = trim($I->grabResponse(), '"');
        $I->canSeeResponseCodeIs(201);

        $user = User::find()->byEmail($invite->email)->one();
        verify($user)->notNull();
        verify(Yii::$app->authManager->checkAccess($user->id, User::ROLE_PATIENT));
        verify($user->patient)->notNull();
        verify((bool) $user->patient->is_unknown)->true();

        $token = UserToken::find()->byUserId($user->id)->byCode($code)->one();
        verify($token)->notNull();
    }
}
