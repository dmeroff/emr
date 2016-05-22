<?php

namespace app\commands;

use app\modules\user\models\User;
use app\modules\user\models\UserInvite;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Command for inviting users.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class InviteController extends Controller
{
    /**
     * Invites user with given email.
     * 
     * @param  string $email
     * @return int|null
     */
    public function actionIndex(string $email)
    {
        $user = User::find()->byEmail($email)->one();
        
        if ($user instanceof User) {
            Console::stderr("User with given email is already registered\n");
            return 1;
        }

        $invite = UserInvite::find()->byEmail($email)->one();

        if ($invite instanceof UserInvite) {
            Console::stderr("User with given email is already invited\n");
            return 1;
        }

        /** @var \app\modules\user\models\UserInvite $newInvite */
        $newInvite = \Yii::createObject([
            'class'    => UserInvite::class,
            'email'    => $email,
            'role'     => User::ROLE_CHIEF,
            'scenario' => UserInvite::SCENARIO_ADMIN,
        ]);

        if ($newInvite->create()) {
            Console::stdout("User has been invited\n");
            return 0;
        } else {
            Console::stderr("Something went wrong and user has not been invited\n");
            foreach ($newInvite->firstErrors as $error) {
                Console::stderr("- $error\n");    
            }
            return 1;
        }
    }
}