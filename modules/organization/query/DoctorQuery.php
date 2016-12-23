<?php

namespace app\modules\organization\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\modules\organization\models\Doctor]].
 *
 * @see \app\models\Doctor
 */
class DoctorQuery extends ActiveQuery
{
    /**
     * @param int $id
     * @return DoctorQuery
     */
    public function byId(int $id) : DoctorQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @inheritdoc
     * @return \app\modules\organization\models\Doctor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\modules\organization\models\Doctor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
