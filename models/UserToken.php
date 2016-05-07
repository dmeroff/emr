<?php

namespace app\models;

use app\query\UserTokenQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string  $code
 * @property string  $created_at
 * @property User    $user
 */
class UserToken extends ActiveRecord
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return \app\query\UserTokenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserTokenQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_token';
    }
}
