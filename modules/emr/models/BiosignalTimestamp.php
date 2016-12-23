<?php

namespace app\modules\emr\models;

use app\modules\emr\query\BiosignalTimestampQuery;
use yii\db\ActiveRecord;

class BiosignalTimestamp extends ActiveRecord
{
    /**
     * @return BiosignalTimestampQuery
     */
    public static function find()
    {
        return new BiosignalTimestampQuery(get_called_class());
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'biosignal_timestamp';
    }
}