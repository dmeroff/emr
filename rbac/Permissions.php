<?php

namespace app\rbac;

/**
 * Class containing constants with permissions names.
 * 
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Permissions
{
    /**
     * Can invite users.
     */
    const INVITE_USERS = 'inviteUsers';

    /**
     * Can manage organizations (create, update, view).
     */
    const MANAGE_ORGANIZATIONS = 'manageOrganizations';
}