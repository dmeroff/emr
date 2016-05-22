<?php

namespace app\tests\codeception\_fixtures;

use app\modules\user\models\User;
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
    public $modelClass = 'app\modules\user\models\User';

    /**
     * @inheritdoc
     */
    public function load()
    {
        parent::load();

        \Yii::$app->authManager->removeAllAssignments();

        $patient = \Yii::$app->authManager->getRole(User::ROLE_PATIENT);
        $doctor  = \Yii::$app->authManager->getRole(User::ROLE_DOCTOR);
        $chief   = \Yii::$app->authManager->getRole(User::ROLE_CHIEF);

        \Yii::$app->authManager->assign($patient, 1);
        \Yii::$app->authManager->assign($doctor, 2);
        \Yii::$app->authManager->assign($chief, 3);
        \Yii::$app->authManager->assign($chief, 4);
    }
}
