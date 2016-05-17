<?php

namespace app\tests\codeception\_fixtures;

use yii\test\ActiveFixture;

/**
 * Fixture for Doctor model.
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class DoctorFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $modelClass = 'app\models\Doctor';
}
