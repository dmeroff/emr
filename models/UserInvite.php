<?php

namespace app\models;

use app\query\UserInviteQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
    const SCENARIO_ADMIN   = 'admin';
    const SCENARIO_DEFAULT = 'default';

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();

        unset($fields['code']);
        unset($fields['referrer_id']);
        unset($fields['referral_id']);

        $fields['registered'] = function (UserInvite $model) {
            return $model->referral_id !== null;
        };

        return $fields;
    }

    /**
     * Creates new invite and sends it via email.
     */
    public function create() : bool
    {
        if (!$this->save()) {
            return false;
        }

        \Yii::$app->mailer->compose('invite', ['userInvite' => $this])
            ->setTo($this->email)
            ->setSubject('Приглашение в систему')
            ->setFrom(\Yii::$app->params['adminEmail'])
            ->send();

        return true;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->code       = random_int(1000000000, 9999999999);
        $this->created_at = new Expression('NOW()');

        return parent::beforeSave($insert);
    }

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
    public function scenarios()
    {
        return [
            self::SCENARIO_ADMIN   => ['email'],
            self::SCENARIO_DEFAULT => ['email', 'role'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => '{attribute} не может быть пустым '],
            ['email', 'email', 'message' => 'Некорректный формат Email адреса'],
            ['email', 'unique', 'targetClass' => User::class,
                'message' => 'Email уже используется другим пользователем'],
            ['email', 'unique', 'message' => 'Пользователь с таким Email уже приглашен'],
            ['role', 'required', 'on' => [self::SCENARIO_DEFAULT], 'message' => 'Роль не может быть пустой'],
            ['role', 'in', 'range' => [User::ROLE_DOCTOR, User::ROLE_PATIENT],
                'message' => 'Вы не можете приглашать пользователей с такой ролью'],
        ];
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
