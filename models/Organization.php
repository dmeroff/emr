<?php

namespace app\models;

use app\query\OrganizationQuery;
use yii\db\ActiveRecord;

/**
 * @property int    $id
 * @property int    $owner_id
 * @property string $code
 * @property string $name
 * @property string $address
 * @property string $attestat_number
 * @property string $chief_name
 * @property string $chief_position_name
 * @property string $chief_phone
 * @property string $chief_email
 *
 * @author Daniil Ilin <dilin@gmail.com>
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Organization extends ActiveRecord
{
    /**
     * @return array
     */
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

    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['owner_id']);

        return $fields;
    }

    /**
     * Creates new organization
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                  => 'ID',
            'owner_id'            => 'ID владельца',
            'code'                => 'Код организации',
            'name'                => 'Имя организации',
            'address'             => 'Адрес',
            'attestat_number'     => 'Номер аттестата',
            'chief_name'          => 'Имя руководителя',
            'chief_position_name' => 'Должность руководителя',
            'chief_phone'         => 'Номер телефона руководителя',
            'chief_email'         => 'Email',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new OrganizationQuery(get_called_class());
    }

}