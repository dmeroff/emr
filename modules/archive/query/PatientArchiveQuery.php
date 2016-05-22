<?php

namespace app\modules\archive\query;

use app\modules\archive\query\OrganizationArchiveQuery;
use yii\db\ActiveQuery;
/**
 * This is the ActiveQuery class for [[\app\modules\archive\models\PatientArchive].
 *
 * @see \app\models\PatientArchive
 */
class PatientArchiveQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return PatientArchiveQuery
     */
    public function byId (int $id) : PatientArchiveQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param  int $id
     * @return PatientArchiveQuery
     */
    public function byOwnerId (int $id) : PatientArchiveQuery
    {
        return $this->andWhere(['owner_id' => $id]);
    }

    /**
     * @param  int $id
     * @return OrganizationArchiveQuery
     */
    public function byRevision(int $revision) : PatientArchiveQuery
    {
        return $this->andWhere(['revision' => $revision]);
    }
}