<?php

use app\modules\user\models\User;
use app\modules\user\models\UserToken;
use yii\db\Query;

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

    public function testDoctorRegister(FunctionalTester $I)
    {
        $chief  = $I->getUserFixture('chief1');
        $invite = $I->getInviteFixture('doctor_invite');

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
        verify($user->doctor)->notNull();
        verify($user->doctor->organization_id)->equals($chief->organization->id);

        $token = UserToken::find()->byUserId($user->id)->byCode($code)->one();
        verify($token)->notNull();
    }

    public function testPatientRegister(FunctionalTester $I)
    {
        $doctor = $I->getUserFixture('doctor');
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
        
        $count = (new Query())
            ->from('patient_to_doctor')
            ->where([
                'patient_id' => $user->patient->id,
                'doctor_id'  => $doctor->doctor->id,
            ])
            ->count();
        verify((int) $count)->greaterThan(0);
    }

}
