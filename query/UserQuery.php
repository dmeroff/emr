<?php

namespace app\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\User]].
 *
 * @see \app\models\User
 */
class UserQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return UserQuery
     */
    public function byId(int $id) : UserQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param  string $email
     * @return UserQuery
     */
    public function byEmail(string $email) : UserQuery
    {
        return $this->andWhere(['email' => $email]);
    }

    /**
     * @inheritdoc
     * @return \app\models\User[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\User|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
