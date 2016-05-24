<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use yii\base\Model;

/**
 * Password recovery request form.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RecoveryRequestForm extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email не может быть пустым'],
            ['email', 'email', 'message' => 'Некорректный формат Email адреса'],
            ['email', 'exist', 'targetClass' => User::class, 'message' => 'Пользователь с заданным Email не существует']
        ];
    }

    /**
     * Generates new recovery code and sends it to user.
     * @return bool
     */
    public function sendRecoveryMessage() : bool
    {
        if (!$this->validate()) {
            return false;
        }
        
        $user = User::find()->byEmail($this->email)->one();
        
        $user->updateAttributes(['recovery_code' => random_int(100000000, 999999999)]);
        
        \Yii::$app->mailer->compose('recovery', ['user' => $user])
            ->setTo($user->email)
            ->setFrom(\Yii::$app->params['adminEmail'])
            ->setSubject('Восстановление пароля')
            ->send();
        
        return true;
    }
}
