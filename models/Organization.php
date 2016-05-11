<?php

namespace app\models;

use app\query\OrganizationQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;


class Organization extends ActiveRecord
{
    public function getId()
    {
        return $this->id;
    }

    public function rules() : array
    {
        return [
            [['chief_email'], 'trim'],
            [['code', 'name', 'address', 'attestat_number', 'chief_name', 'chief_position_name',
                'chief_phone', 'chief_email'], 'required', 'message' => '{attribute} не может быть пустым'],
            ['chief_email', 'email', 'message' => 'Некорректный формат Email адреса'],
            ['chief_email', 'unique', 'message' => 'Email уже используется'],
            ['code', 'string', 'max' => 12,
                'tooLong' => 'Код не может быть длиннее 12 символов'],
            ['name', 'string', 'max' => 255,
                'tooLong' => 'Имя не может быть длиннее 255 символов'],
            ['attestat_number', 'string', 'max' => 255,
                'tooLong' => 'Имя не может быть длиннее 255 символов'],
            ['chief_name', 'string', 'max' => 255,
                'tooLong' => 'Имя не может быть длиннее 255 символов'],
            ['chief_position_name', 'string', 'max' => 255,
                'tooLong' => 'Имя не может быть длиннее 255 символов'],
        ];
    }

    public function create() : bool
    {
        $transaction = $this->getDb()->beginTransaction();

        try {
            if (!$this->validate()) {
                return false;
            }


            $this->owner_id = \Yii::$app->user->id;

            $this->save(false);

            $transaction->commit();

            return true;
        } catch (\Throwable $e) {
            \Yii::error($e);

            $transaction->rollBack();

            return false;
        }
    }


    public function attributeLabels()
    {
        return [
            'id'                    => 'ID',
            'owner_id'              => 'ID владельца',
            'code'                  => 'Код организации',
            'name'                  => 'Имя организации',
            'address'               => 'Адрес',
            'attestat_number'       => 'Номер аттестата',
            'chief_name'            => 'Имя руководителя',
            'chief_position_name'   => 'Должность руководителя',
            'chief_phone'           => 'Номер телефона руководителя',
            'chief_email'           => 'Email',
        ];
    }


    public static function tableName()
    {
        return 'organization';
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function find()
    {
        return new OrganizationQuery(get_called_class());
    }

}