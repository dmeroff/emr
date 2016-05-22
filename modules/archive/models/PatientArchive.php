<?php

namespace app\modules\archive\models;

use app\modules\archive\query\PatientArchiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int    $id
 * @property int    $organization_id
 * @property int    $user_id
 * @property int    $is_unknown
 * @property string $snils
 * @property string $inn
 * @property string $name
 * @property string $patronymic
 * @property string $surname
 * @property string $birhday
 * @property string $birthplace
 * @property int    $gender
 * @property string $action
 * @property int    $revision
 * @property string $dt_datetime
 *
 * @author Daniil Ilin <dilin@gmail.com>
 */
class PatientArchive extends ActiveRecord
{

    /**
     * @return array
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['user_id']);
        unset($fields['organization_id']);

        return $fields;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'patient_archive';
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new PatientArchiveQuery(get_called_class());
    }

}