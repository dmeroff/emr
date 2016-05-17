<?php

namespace app\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Patient]].
 *
 * @see \app\models\Patient
 */
class PatientQuery extends ActiveQuery
{
    /**
     * @param  int $id
     * @return PatientQuery
     */
    public function byId(int $id) : PatientQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param  int $id
     * @return PatientQuery
     */
    public function byOrganizationId(int $id) : PatientQuery
    {
        return $this->andWhere(['organization_id' => $id]);
    }

    /**
     * @param  int $doctorId
     * @return PatientQuery
     */
    public function byDoctorId(int $doctorId) : PatientQuery
    {
        return $this
            ->innerJoin(['ptd' => 'patient_to_doctor'], 'ptd.patient_id = patient.id')
            ->andWhere(['ptd.doctor_id' => $doctorId]);
    }

    /**
     * @param  int $id
     * @return PatientQuery
     */
    public function byUserId(int $id) : PatientQuery
    {
        return $this->andWhere(['user_id' => $id]);
    }

    /**
     * @inheritdoc
     * @return \app\models\Patient[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Patient|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
