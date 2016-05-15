<?php

namespace app\tests\codeception\_fixtures;

use yii\test\ActiveFixture;

/**
 * Fixture for User invite model.
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class InviteFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $modelClass = 'app\models\UserInvite';
}
