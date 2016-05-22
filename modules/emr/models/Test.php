<?php

namespace app\modules\emr\models;

use app\modules\emr\models\Patient;
use app\modules\emr\query\TestQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $patient_id
 * @property string  $data
 * @property string  $created_at
 * @property array   $decodedData
 * @property Patient $patient
 */
class Test extends ActiveRecord
{
    /**
     * @var array
     */
    private $_decodedData;

    /**
     * @return array
     */
    public function getDecodedData() : array
    {
        if ($this->_decodedData === null) {
            $this->_decodedData = Json::decode($this->data);
        }

        return $this->_decodedData;
    }

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
            $this->data       = Json::encode($this->data);
        }
        
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @return \app\modules\emr\query\TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestQuery(get_called_class());
    }
}
