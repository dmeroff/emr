<?php

use app\modules\user\forms\RecoveryForm;
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

class RecoveryTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testValidation()
    {
        $model = new RecoveryForm();

        $model->password = null;
        verify($model->validate(['password']))->false();
        verify($model->getFirstError('password'))->equals('Пароль не может быть пустым');

        $model->code = null;
        verify($model->validate(['code']))->false();
        verify($model->getFirstError('code'))->equals('Код не может быть пустым');

        $model->code = 'invalidcode';
        verify($model->validate(['code']))->false();
        verify($model->getFirstError('code'))->equals('Некорректный код');
    }

    public function testRecovery()
    {
        $user  = $this->getUserFixture('patient');
        $model = new RecoveryRequestForm();
        $model->email = $user->email;

        $model->sendRecoveryMessage();
        $user->refresh();

        $oldHash = $user->password_hash;

        $model = new RecoveryForm();
        $model->code     = $user->recovery_code;
        $model->password = 'newPassword';
        $model->recoverPassword();

        $user->refresh();

        verify($oldHash)->notEquals($user->password_hash);
        verify($user->recovery_code)->null();
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