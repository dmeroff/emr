<?php

namespace app\modules\user\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\modules\user\models\UserToken]].
 *
 * @see \app\models\UserToken
 */
class UserTokenQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return UserTokenQuery
     */
    public function byId(int $id) : UserTokenQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param  int $id
     * @return UserTokenQuery
     */
    public function byUserId(int $id) : UserTokenQuery
    {
        return $this->andWhere(['user_id' => $id]);
    }

    /**
     * @param  string $code
     * @return UserTokenQuery
     */
    public function byCode(string $code) : UserTokenQuery
    {
        return $this->andWhere(['code' => $code]);
    }
    
    /**
     * @inheritdoc
     * @return \app\modules\user\models\UserToken[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\user\models\UserToken|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
