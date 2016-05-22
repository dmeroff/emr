<?php

namespace app\tests\codeception\_fixtures;

use yii\test\ActiveFixture;

/**
 * Fixture for Test model.
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class TestFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $modelClass = 'app\modules\emr\models\Test';
}
