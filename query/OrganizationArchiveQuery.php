<?php

namespace app\query;

use yii\db\ActiveQuery;
/**
 * This is the ActiveQuery class for [[\app\models\OrganizationArchive].
 *
 * @see \app\models\OrganizationArchive
 */
class OrganizationArchiveQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return OrganizationArchiveQuery
     */
    public function byOwnerId (int $id) : OrganizationArchiveQuery
    {
        return $this->andWhere(['owner_id' => $id]);
    }

    /**
     * @param  int $id
     * @return OrganizationArchiveQuery
     */
    public function byId(int $id) : OrganizationArchiveQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param  int $revision
     * @return OrganizationArchiveQuery
     */
    public function byRevision(int $revision) : OrganizationArchiveQuery
    {
        return $this->andWhere(['revision' => $revision]);
    }
}