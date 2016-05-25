<?php

use app\modules\user\forms\RecoveryRequestForm;
use app\tests\codeception\_fixtures\DoctorFixture;
use app\tests\codeception\_fixtures\InviteFixture;
use app\tests\codeception\_fixtures\OrganizationFixture;
use app\tests\codeception\_fixtures\PatientFixture;
use app\tests\codeception\_fixtures\TestFixture;
use app\tests\codeception\_fixtures\UserTokenFixture;
use app\tests\codeception\_fixtures\UserFixture;
use tests\codeception\_fixtures\BaseFixture;
use yii\codeception\TestCase;

class RecoveryRequestFormTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testValidation()
    {
        $model = new RecoveryRequestForm();

        $model->email = null;
        verify($model->validate(['email']))->false();
        verify($model->getFirstError('email'))->equals('Email не может быть пустым');

        $model->email = 'invalid email';
        verify($model->validate(['email']))->false();
        verify($model->getFirstError('email'))->equals('Некорректный формат Email адреса');

        $model->email = 'user-does-not-exist@example.com';
        verify($model->validate(['email']))->false();
        verify($model->getFirstError('email'))->equals('Пользователь с заданным Email не существует');

        $user = $this->getUserFixture('patient');
        $model->email = $user->email;
        verify($model->validate());
    }

    public function testRecovery()
    {
        $user  = $this->getUserFixture('patient');
        $model = new RecoveryRequestForm();
        $model->email = $user->email;

        verify($model->sendRecoveryMessage());
        $user->refresh();
        verify($user->recovery_code)->notNull();
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
}