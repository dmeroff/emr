<?php

namespace app\models;
use app\query\UserQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string  $email
 * @property string  $password_hash
 * @property string  $created_at
 * @property string  $recovery_code
 *
 * @property Organization[] $organizations
 * @property Patient        $patient
 * @property UserInvite[]   $invites
 */
class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_PATIENT = 'patient';
    const ROLE_DOCTOR  = 'doctor';
    const ROLE_CHIEF   = 'chief';
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations()
    {
        return $this->hasMany(Organization::className(), ['owner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPatients()
    {
        return $this->hasMany(Patient::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvites()
    {
        return $this->hasMany(UserInvite::className(), ['referral_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'email'         => 'Email',
            'password_hash' => 'Хэш пароля',
            'created_at'    => 'Время создания',
            'recovery_code' => 'Код восстановления пароля',
        ];
    }

    /**
     * @inheritdoc
     * @return \app\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return UserToken::find()->byCode($token)->one()->user ?? null;
    }
}
