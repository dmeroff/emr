<?php

namespace app\models;

use app\query\BiosignalQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "biosignal".
 *
 * @property integer  $id
 * @property integer  $patient_id
 * @property resource $data
 * @property string   $created_at
 *
 * @property Patient $patient
 */
class Biosignal extends ActiveRecord
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Patient::className(), ['id' => 'patient_id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->patient_id = \Yii::$app->user->identity->patient->id;
            $this->created_at = new Expression('NOW()');
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @return \app\query\BiosignalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BiosignalQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'biosignal';
    }
}
