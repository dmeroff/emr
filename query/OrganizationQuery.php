<?php

namespace app\query;

use yii\db\ActiveQuery;

class OrganizationQuery extends ActiveQuery
{
    public function byOwnerId(int $id) : OrganizationQuery
    {
        return $this->andWhere(['owner_id' => $id]);
    }
}