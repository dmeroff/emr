<?php

use app\modules\user\models\UserToken;
use yii\helpers\Json;

class TokenCest
{
    public function testTokenCreate(FunctionalTester $I)
    {
        $patient = $I->getUserFixture('patient');

        $I->sendPOST('tokens', [
            'email'    => $patient->email,
            'password' => 'qwerty',
        ]);
        $I->seeResponseCodeIs(201);

        $code  = Json::decode($I->grabResponse());
        $token = UserToken::find()->byCode($code)->byUserId($patient->id)->one();
        verify($token)->notNull();
    }

    public function testTokenDelete(FunctionalTester $I)
    {
        $patient = $I->getUserFixture('patient');
        $token   = $I->getTokenFixture('patient_auth_token');
        $I->amHttpAuthenticated($token->code, '');
        $I->sendDELETE('tokens');
        $I->seeResponseCodeIs(204);

        $token = UserToken::find()->byCode($token->code)->byUserId($patient->id)->one();
        verify($token)->null();
    }
}
