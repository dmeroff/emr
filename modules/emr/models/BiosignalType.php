<?php

namespace app\modules\emr\models;

use app\modules\emr\query\BiosignalTypeQuery;
use yii\db\ActiveRecord;

class BiosignalType extends ActiveRecord
{
    /**
     * @return mixed
     */
    public function rules() : array
    {
        return [
            ['description', 'required', 'message' => '{attribute} не может быть пустым'],
            ['description', 'string', 'max' => 255,
                'tooLong' => 'Описание не может быть длиннее 255 символов'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels() : array
    {
        return [
            'id' => 'ID',
            'description' => 'Описание биосигнала',
        ];
    }


        /**
     * @return BiosignalTypeQuery
     */
    public static function find() : BiosignalTypeQuery
    {
        return new BiosignalTypeQuery(get_called_class());
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'biosignal_type';
    }
}