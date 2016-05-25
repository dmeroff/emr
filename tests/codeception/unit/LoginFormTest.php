<?php

use app\modules\user\forms\LoginForm;
use app\tests\codeception\_fixtures\DoctorFixture;
use app\tests\codeception\_fixtures\InviteFixture;
use app\tests\codeception\_fixtures\OrganizationFixture;
use app\tests\codeception\_fixtures\PatientFixture;
use app\tests\codeception\_fixtures\TestFixture;
use app\tests\codeception\_fixtures\UserTokenFixture;
use app\tests\codeception\_fixtures\UserFixture;
use tests\codeception\_fixtures\BaseFixture;
use yii\codeception\TestCase;

class LoginFormTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testValidation()
    {
        $user  = $this->getUserFixture('patient');
        $model = new LoginForm();

        $model->email = null;
        verify($model->validate(['email']))->false();
        verify($model->getFirstError('email'))->equals('Email не может быть пустым');

        $model->password = null;
        verify($model->validate(['password']))->false();
        verify($model->getFirstError('password'))->equals('Пароль не может быть пустым');

        $model->email = $user->email;
        $model->password = 'wrongpass';
        verify($model->validate(['password']))->false();
        verify($model->getFirstError('password'))->equals('Некорректный пароль');

        $model->email = $user->email;
        $model->password = 'qwerty';
        verify($model->validate())->true();
    }

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'user'         => UserFixture::className(),
            'user_token'   => UserTokenFixture::className(),
            'invite'       => InviteFixture::className(),
            'patient'      => PatientFixture::className(),
            'test'         => TestFixture::className(),
            'organization' => OrganizationFixture::className(),
            'doctor'       => DoctorFixture::className(),
            'base'         => BaseFixture::className(),
        ];
    }

    /**
     * @param  string $name
     * @return \app\modules\user\models\User
     * @throws \yii\base\InvalidConfigException
     */
    public function getUserFixture($name)
    {
        return $this->getFixture('user')->getModel($name);
    }

    /**
     * @param  string $name
     * @return \app\modules\user\models\UserInvite
     * @throws \yii\base\InvalidConfigException
     */
    public function getInviteFixture($name)
    {
        return $this->getFixture('invite')->getModel($name);
    }
}