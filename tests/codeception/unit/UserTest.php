<?php

use app\modules\user\models\User;
use app\tests\codeception\_fixtures\DoctorFixture;
use app\tests\codeception\_fixtures\InviteFixture;
use app\tests\codeception\_fixtures\OrganizationFixture;
use app\tests\codeception\_fixtures\PatientFixture;
use app\tests\codeception\_fixtures\TestFixture;
use app\tests\codeception\_fixtures\UserTokenFixture;
use app\tests\codeception\_fixtures\UserFixture;
use tests\codeception\_fixtures\BaseFixture;
use yii\codeception\TestCase;

class UserTest extends TestCase
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testValidation()
    {
        $user = new User();

        $user->email = null;
        verify($user->validate(['email']))->false();
        verify($user->getFirstError('email'))->equals('Email не может быть пустым');

        $user->password = null;
        verify($user->validate(['password']))->false();
        verify($user->getFirstError('password'))->equals('Пароль не может быть пустым');

        $user->inviteCode = null;
        verify($user->validate(['inviteCode']))->false();
        verify($user->getFirstError('inviteCode'))->equals('Инвайт код не может быть пустым');

        $user->email = 'invalid email';
        verify($user->validate(['email']))->false();
        verify($user->getFirstError('email'))->equals('Некорректный формат Email адреса');

        $invite = $this->getInviteFixture('chief_invite');

        $user->email = $invite->email;
        $user->inviteCode = 'invalidCode';
        verify($user->validate(['email']))->true();
        verify($user->validate(['inviteCode']))->false();
        verify($user->getFirstError('inviteCode'))->equals('Некорректный инвайт код');

        $user->email = $invite->email;
        $user->inviteCode = $invite->code;
        $user->password = 'qwerty';
        verify($user->validate())->true();
    }

    public function testRegister()
    {
        $invite = $this->getInviteFixture('chief_invite');
        $user   = new User();

        $user->email      = $invite->email;
        $user->inviteCode = $invite->code;
        $user->password   = 'qwerty';

        verify($user->register())->true();
        verify($user->isNewRecord)->false();
        $invite->refresh();
        verify($invite->referral_id)->equals($user->id);
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
     * @return \app\modules\user\models\UserInvite
     * @throws \yii\base\InvalidConfigException
     */
    public function getInviteFixture($name)
    {
        return $this->getFixture('invite')->getModel($name);
    }
}