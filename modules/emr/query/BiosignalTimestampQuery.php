<?php

namespace app\modules\emr\query;

use yii\db\ActiveQuery;

class BiosignalTimestampQuery extends ActiveQuery
{
    /**
     * @param int $id
     * @return BiosignalTimestampQuery
     */
    public function byId(int $id) : BiosignalTimestampQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param int $id
     * @return BiosignalTimestampQuery
     */
    public function byBiosignalId(int $id) : BiosignalTimestampQuery
    {
        return $this->andWhere(['biosignal_id' => $id]);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|null|\yii\db\ActiveRecord
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}