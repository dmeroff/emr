<?php

namespace app\models;

use app\query\UserTokenQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
     * Saves the model and returns code.
     * 
     * @return string
     */
    public function create() : string
    {
        $this->save();
        
        return $this->code;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->code       = \Yii::$app->security->generateRandomString();
        $this->created_at = new Expression('NOW()');
        
        return parent::beforeSave($insert);
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
