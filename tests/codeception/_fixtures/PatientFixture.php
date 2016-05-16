<?php

namespace app\tests\codeception\_fixtures;

use yii\test\ActiveFixture;

/**
 * Fixture for Patient model.
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class PatientFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $modelClass = 'app\models\Patient';
}
