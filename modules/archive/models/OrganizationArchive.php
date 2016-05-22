<?php

namespace app\modules\archive\models;

use app\modules\archive\query\OrganizationArchiveQuery;
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
 * @property string $action
 * @property int    $revision
 * @property string $dt_datetime
 *
 * @author Daniil Ilin <dilin@gmail.com>
 */
class OrganizationArchive extends ActiveRecord
{

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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'action'              => 'Действие',
            'revision'            => 'Ревизия',
            'dt_datetime'         => 'Дата изменения',
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
        return 'organization_archive';
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new OrganizationArchiveQuery(get_called_class());
    }

}