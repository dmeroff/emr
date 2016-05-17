<?php

namespace app\query;

/**
 * This is the ActiveQuery class for [[\app\models\Doctor]].
 *
 * @see \app\models\Doctor
 */
class DoctorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Doctor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Doctor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
