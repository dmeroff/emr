<?php

namespace app\modules\user\forms;

use app\modules\user\models\User;
use yii\base\Model;

/**
 * Password recovery form.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RecoveryForm extends Model
{
    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $code;

    /**
     * @var User
     */
    private $_user;

    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            [['password', 'code'], 'required'],
            ['password', 'string', 'min' => 6, 'max' => 72,
                'tooShort' => 'Пароль не может быть короче 6 символов',
                'tooLong' => 'Пароль не может быть длиннее 72 символов'],
            ['code', 'validateRecoveryCode'],
        ];
    }

    /**
     * Validates recovery code and finds user.
     */
    public function validateRecoveryCode()
    {
        $this->_user = User::find()->byRecoveryCode($this->code)->one();

        if ($this->_user === null) {
            $this->addError('code', 'Некорректный код');
        }
    }

    /**
     * Recovers users password.
     */
    public function recoverPassword() : bool
    {
        if (!$this->validate() || $this->_user === null) {
            return false;
        }
        
        $this->_user->password      = $this->password;
        $this->_user->recovery_code = null;

        return $this->_user->save(false);
    }
}