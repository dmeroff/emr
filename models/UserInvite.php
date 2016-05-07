<?php

namespace app\models;

use app\query\UserInviteQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_invite".
 *
 * @property integer $id
 * @property integer $referrer_id
 * @property integer $referral_id
 * @property string  $email
 * @property string  $code
 * @property string  $created_at
 * @property string  $role
 * @property User    $referral
 * @property User    $referrer
 */
class UserInvite extends ActiveRecord
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferral()
    {
        return $this->hasOne(User::className(), ['id' => 'referral_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferrer()
    {
        return $this->hasOne(User::className(), ['id' => 'referrer_id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'referrer_id' => 'ID приглашенного',
            'referral_id' => 'ID пригласившего',
            'email'       => 'Email',
            'code'        => 'Код',
            'created_at'  => 'Время создания',
            'role'        => 'Роль нового пользователя',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\query\UserInviteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserInviteQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_invite';
    }
}
