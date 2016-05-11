<?php

namespace app\tests\codeception\_fixtures;

use yii\test\ActiveFixture;

/**
 * Fixture for User model.
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class UserFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $modelClass = 'app\models\User';
}
