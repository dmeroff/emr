<?php

namespace app\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Test]].
 *
 * @see \app\models\Test
 */
class TestQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return TestQuery
     */
    public function byId(int $id) : TestQuery
    {
        return $this->andWhere(['id' => $id]);
    }
    
    /**
     * @param  int $id
     * @return TestQuery
     */
    public function byPatientId(int $id) : TestQuery
    {
        return $this->andWhere(['patient_id' => $id]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Test[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Test|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
