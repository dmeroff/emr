<?php

namespace app\models;

use app\query\UserQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string  $email
 * @property string  $password_hash
 * @property string  $created_at
 * @property string  $recovery_code
 * @property string  $authToken
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
     * @var string
     */
    public $inviteCode;

    /**
     * @var string
     */
    public $password;

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
    public function validateAuthKey($authKey) : bool
    {
        return false;
    }

    /**
     * Validates password and rehashes it if needed.
     * 
     * @param  string $password
     * @return bool
     */
    public function validatePassword(string $password) : bool
    {
        if (password_verify($password, $this->password_hash)) {
            if (password_needs_rehash($this->password_hash, PASSWORD_DEFAULT)) {
                $this->updateAttributes([
                    'password_hash' => password_hash($password, PASSWORD_DEFAULT),
                ]);
            }
            
            return true;
        }

        return false;
    }

    /**
     * Creates new auth token for this user.
     *
     * @return string
     */
    public function getAuthToken() : string
    {
        return (new UserToken(['user_id' => $this->id]))->create();
    }

    /**
     * @inheritdoc
     */
    public function rules() : array
    {
        return [
            [['email', 'inviteCode'], 'trim'],
            [['email', 'inviteCode', 'password'], 'required', 'message' => '{attribute} не может быть пустым'],
            ['email', 'email', 'message' => 'Некорректный формат Email адреса'],
            ['email', 'unique', 'message' => 'Email уже используется'],
            ['password', 'string', 'min' => 6, 'max' => 72,
                'tooShort' => 'Пароль не может быть короче 6 символов',
                'tooLong' => 'Пароль не может быть длиннее 72 символов'],
            ['inviteCode', 'validateInviteCode'],
        ];
    }

    /**
     * Checks invite code.
     * @param $attribute
     */
    public function validateInviteCode(string $attribute)
    {
        $invite = UserInvite::find()->byCode($this->inviteCode)->byEmail($this->email)->one();

        if ($invite === null) {
            $this->addError($attribute, 'Некорректный инвайт код');
        }
    }

    /**
     * Registers user and sends welcome message to email.
     *
     * @return bool
     */
    public function register() : bool
    {
        $transaction = $this->getDb()->beginTransaction();

        try {
            if (!$this->validate()) {
                return false;
            }
            
            $this->save(false);

            \Yii::$app->mailer->compose('register', ['user' => $this])
                ->setTo($this->email)
                ->setSubject('Регистрация в системе')
                ->setFrom(\Yii::$app->params['adminEmail'])
                ->send();

            UserInvite::deleteAll(['code' => $this->inviteCode, 'email' => $this->email]);

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
    public function beforeSave($insert)
    {
        if ($this->password != null) {
            $this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        }

        if ($this->isNewRecord) {
            $this->created_at = new Expression('NOW()');
        }

        return parent::beforeSave($insert);
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
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'email'         => 'Email',
            'password_hash' => 'Хэш пароля',
            'created_at'    => 'Время создания',
            'recovery_code' => 'Код восстановления пароля',
            'password'      => 'Пароль',
            'inviteCode'    => 'Инвайт код',
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
