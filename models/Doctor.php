<?php

namespace app\models;

use app\query\DoctorQuery;
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
     * @return \app\query\DoctorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DoctorQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'doctor';
    }
}
