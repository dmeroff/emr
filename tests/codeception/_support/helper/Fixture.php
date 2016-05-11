<?php

namespace Helper;

use Codeception\Module;
use Codeception\TestCase;
use app\tests\codeception\_fixtures\UserTokenFixture;
use app\tests\codeception\_fixtures\UserFixture;
use yii\test\FixtureTrait;
use yii\test\BaseActiveFixture;

/**
 * Fixture helper
 *
 * @method BaseActiveFixture getFixture($name)
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Fixture extends Module
{
    use FixtureTrait;

    /**
     * @var array
     */
    public static $excludeActions = ['loadFixtures', 'unloadFixtures', 'getFixtures', 'globalFixtures', 'fixtures'];

    /**
     * @param TestCase $testcase
     */
    public function _before(TestCase $testcase)
    {
        $this->unloadFixtures();
        $this->loadFixtures();
        parent::_before($testcase);
    }

    /**
     * @param TestCase $testcase
     */
    public function _after(TestCase $testcase)
    {
        $this->unloadFixtures();
        parent::_after($testcase);
    }

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'user'       => UserFixture::className(),
            'user_token' => UserTokenFixture::className(),
        ];
    }

    /**
     * @param  string $name
     * @return \app\models\User
     * @throws \yii\base\InvalidConfigException
     */
    public function getUserFixture($name)
    {
        return $this->getFixture('user')->getModel($name);
    }

    /**
     * @param  string $name
     * @return \app\models\UserToken
     * @throws \yii\base\InvalidConfigException
     */
    public function getTokenFixture($name)
    {
        return $this->getFixture('user_token')->getModel($name);
    }
}