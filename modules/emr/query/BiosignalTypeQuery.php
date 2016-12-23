<?php

namespace app\modules\emr\query;

use yii\db\ActiveQuery;

class BiosignalTypeQuery extends ActiveQuery
{
    /**
     * @param int $id
     * @return BiosignalTypeQuery
     */
    public function byId(int $id) : BiosignalTypeQuery
    {
        return $this->andWhere(['id' => $id]);
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