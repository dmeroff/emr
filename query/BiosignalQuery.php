<?php

namespace app\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Biosignal]].
 *
 * @see \app\models\Biosignal
 */
class BiosignalQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return BiosignalQuery
     */
    public function byId(int $id) : BiosignalQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param  int $doctorId
     * @return BiosignalQuery
     */
    public function byDoctorId(int $doctorId) : BiosignalQuery
    {
        return $this
            ->innerJoin(['ptd' => 'patient_to_doctor'], 'ptd.patient_id = biosignal.patient_id')
            ->andWhere(['ptd.doctor_id' => $doctorId]);
    }

    /**
     * @param  int $id
     * @return BiosignalQuery
     */
    public function byPatientId(int $id) : BiosignalQuery
    {
        return $this->andWhere(['biosignal.patient_id' => $id]);
    }
    
    /**
     * @inheritdoc
     * @return \app\models\Biosignal[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Biosignal|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
