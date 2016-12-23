<?php

namespace app\modules\organization\models;

use app\modules\emr\models\PatientToDoctor;
use app\modules\organization\query\DoctorQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "doctor".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $organization_id
 * @property string  $name
 * @property string  $patronymic
 * @property string  $surname
 */
class Doctor extends ActiveRecord
{
    /**
     * @inheritdoc
     * @return \app\modules\organization\query\DoctorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DoctorQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatients()
    {
        return $this->hasMany('patient_to_doctor', ['patient_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor';
    }
}
