<?php

namespace app\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\UserInvite]].
 *
 * @see \app\models\UserInvite
 */
class UserInviteQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return UserInviteQuery
     */
    public function byId(int $id) : UserInviteQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param  int $id
     * @return UserInviteQuery
     */
    public function byReferralId(int $id) : UserInviteQuery
    {
        return $this->andWhere(['referral_id' => $id]);
    }

    /**
     * @param  int $id
     * @return UserInviteQuery
     */
    public function byReferrerId(int $id) : UserInviteQuery
    {
        return $this->andWhere(['referrer_id' => $id]);
    }
    
    /**
     * @param  string $code
     * @return UserInviteQuery
     */
    public function byCode(string $code) : UserInviteQuery
    {
        return $this->andWhere(['code' => $code]);
    }

    /**
     * @param  string $email
     * @return UserInviteQuery
     */
    public function byEmail(string $email) : UserInviteQuery
    {
        return $this->andWhere(['email' => $email]);
    }

    /**
     * @inheritdoc
     * @return \app\models\UserInvite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\UserInvite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
