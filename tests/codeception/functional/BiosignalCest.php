<?php

use app\models\Biosignal;

class BiosignalCest
{
    public function testUploadBiosignal(FunctionalTester $I)
    {
        $patient = $I->getUserFixture('patient');
        $token   = $I->getTokenFixture('patient_auth_token');

        $I->amHttpAuthenticated($token->code, '');
        $I->sendPOST('biosignals', [], [
            'data' => codecept_data_dir('picture.png'),
        ]);
        $I->canSeeResponseCodeIs(201);
        
        $biosignal = Biosignal::find()->byPatientId($patient->id)->one();
        verify($biosignal)->notNull();
        verify($biosignal->data)->equals(file_get_contents(codecept_data_dir('picture.png')));
    }
}
