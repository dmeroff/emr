<?php

namespace app\commands;

use app\models\User;
use app\rbac\Permissions;
use rmrevin\yii\rbac\Command;
use rmrevin\yii\rbac\RbacFactory;

/**
 * Rbac command.
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RbacController extends Command
{
    /**
     * @return \yii\rbac\Role[]
     */
    protected function roles()
    {
        return [
            RbacFactory::Role(User::ROLE_PATIENT),
            RbacFactory::Role(User::ROLE_DOCTOR),
            RbacFactory::Role(User::ROLE_CHIEF),
        ];
    }

    /**
     * @return \yii\rbac\Rule[]
     */
    protected function rules()
    {
        return [
            
        ];
    }

    /**
     * @return \yii\rbac\Permission[]
     */
    protected function permissions()
    {
        return [
            RbacFactory::Permission(Permissions::INVITE_USERS),
        ];
    }

    /**
     * @return array
     */
    protected function inheritanceRoles()
    {
        return [
            User::ROLE_CHIEF => [
                User::ROLE_DOCTOR,
            ],
            User::ROLE_DOCTOR => [
                User::ROLE_PATIENT,
            ],
        ];
    }

    /**
     * @return array
     */
    protected function inheritancePermissions()
    {
        return [
            User::ROLE_DOCTOR => [
                Permissions::INVITE_USERS,
            ],
        ];
    }
}