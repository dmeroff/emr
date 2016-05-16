<?php

namespace app\query;

use app\models\OrganizationArchive;
use yii\db\ActiveQuery;

class OrganizationArchiveQuery extends ActiveQuery
{
    public function byOwnerId (int $id) : OrganizationArchiveQuery
    {
        return $this->andWhere(['owner_id' => $id]);
    }

    public function byId(int $id) : OrganizationArchiveQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    public function byRevision(int $revision) : OrganizationArchiveQuery
    {
        return $this->andWhere(['revision' => $revision]);
    }
}