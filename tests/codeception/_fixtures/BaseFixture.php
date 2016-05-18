<?php

namespace tests\codeception\_fixtures;
use yii\test\Fixture;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class BaseFixture extends Fixture
{
    public function load()
    {
        $count = \Yii::$app->db->createCommand()->batchInsert('patient_to_doctor', [
            'patient_id',
            'doctor_id',
        ], [
            [1, 1],
            [2, 1],
        ])->execute();
    }
    
    public function unload()
    {
        \Yii::$app->db->createCommand()->delete('patient_to_doctor')->execute();
    }
}