<?php

namespace app\models;

use app\query\TestQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $patient_id
 * @property string  $data
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
            $this->data = Json::encode($this->data);
        }
        
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     * @return \app\query\TestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestQuery(get_called_class());
    }
}
