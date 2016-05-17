<?php

namespace app\models;

use app\query\PatientQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "patient".
 *
 * @property integer      $id
 * @property integer      $organization_id
 * @property integer      $user_id
 * @property integer      $is_unknown
 * @property string       $snils
 * @property string       $inn
 * @property string       $name
 * @property string       $patronymic
 * @property string       $surname
 * @property string       $birthday
 * @property string       $birthplace
 * @property integer      $gender
 * @property Biosignal[]  $biosignals
 * @property Organization $organization
 * @property User         $user
 * @property Test[]       $tests
 */
class Patient extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'ID организации',
            'user_id' => 'ID пользователя',
            'is_unknown' => 'Неизвестный',
            'snils' => 'СНИЛС',
            'inn' => 'ИНН',
            'name' => 'Имя',
            'patronymic' => 'Отчество',
            'surname' => 'Фамилия',
            'birthday' => 'День рождения',
            'birthplace' => 'Место рождения',
            'gender' => 'Пол',
        ];
    }


    /**
     * Creates new patient
     * @return bool
     * @throws \yii\db\Exception
     */
    public function create() : bool
    {
        $transaction = $this->getDb()->beginTransaction();

        try {
            if (!$this->validate()) {
                return false;
            }

            $this->doctor_id = \Yii::$app->user->id;

            $this->save(false);

            $transaction->commit();

            return true;
        } catch (\Throwable $e) {
            \Yii::error($e);

            $transaction->rollBack();

            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiosignals()
    {
        return $this->hasMany(Biosignal::className(), ['patient_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganization()
    {
        return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTests()
    {
        return $this->hasMany(Test::className(), ['patient_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\query\PatientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PatientQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient';
    }
}
