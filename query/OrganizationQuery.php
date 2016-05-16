<?php

namespace app\query;

use yii\db\ActiveQuery;
/**
 * This is the ActiveQuery class for [[\app\models\Organization].
 *
 * @see \app\models\Organization
 */
class OrganizationQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return OrganizationQuery
     */
    public function byOwnerId (int $id) : OrganizationQuery
    {
        return $this->andWhere(['owner_id' => $id]);
    }

    /**
     * @param  int $id
     * @return OrganizationQuery
     */
    public function byId(int $id) : OrganizationQuery
    {
        return $this->andWhere(['id' => $id]);
    }
}