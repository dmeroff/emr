<?php

class RecoveryCest
{
    public function testPasswordRecovery(FunctionalTester $I)
    {
        $patient = $I->getUserFixture('patient');

        // try to login with old password
        $I->sendPOST('tokens', ['email' => $patient->email, 'password' => 'qwerty']);
        $I->seeResponseCodeIs(201);
        verify($patient->recovery_code)->null();

        // request password recovery
        $I->sendPOST('recovery', ['email' => $patient->email]);
        $I->seeResponseCodeIs(201);
        $I->canSeeResponseEquals('');

        $patient->refresh();
        verify($patient->recovery_code)->notNull();

        // try to reset password
        $newPassword = 'newPassword';
        $I->sendPUT('user/password', ['password' => $newPassword, 'code' => $patient->recovery_code]);
        $I->seeResponseCodeIs(204);
        $I->canSeeResponseEquals('');
        $patient->refresh();
        verify($patient->recovery_code)->null();

        // try to login with old password
        $I->sendPOST('tokens', ['email' => $patient->email, 'password' => 'qwerty']);
        $I->seeResponseCodeIs(422);

        // try to login with new password
        $I->sendPOST('tokens', ['email' => $patient->email, 'password' => $newPassword]);
        $I->seeResponseCodeIs(201);
    }
}
