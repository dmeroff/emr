<?php

use app\modules\emr\models\Test;
use yii\helpers\Json;

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
    
    public function testViewingTests(FunctionalTester $I)
    {
        $tests = require __DIR__ . '/../_fixtures/data/test.php';
        $token = $I->getTokenFixture('doctor_auth_token');

        $I->amHttpAuthenticated($token->code, '');
        $I->sendGET('tests');
        $I->canSeeResponseCodeIs(200);

        verify(Json::decode($I->grabResponse()))->equals($tests);

        unset($tests[2]);
        $I->sendGET('tests/1');
        $I->canSeeResponseCodeIs(200);
        verify(Json::decode($I->grabResponse()))->equals($tests);
    }
}
