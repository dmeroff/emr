<?php

use app\models\Test;

class TestCest
{
    public function testUploadingTests(FunctionalTester $I)
    {
        $token    = $I->getTokenFixture('patient_auth_token');
        $patient  = $I->getUserFixture('patient');
        $testData = [
            'question1' => [
                'result' => 5,
            ],
            'question2' => [
                'result' => 3,
            ],
            'question3' => [
                'result' => 4,
            ],
        ];

        $I->amHttpAuthenticated($token->code, '');
        $I->sendPOST('tests', $testData);
        $I->canSeeResponseCodeIs(201);

        $test = Test::find()->byPatientId($patient->patient->id)->one();
        verify($test)->notNull();
        verify($test->decodedData)->equals($testData);
    }
}
