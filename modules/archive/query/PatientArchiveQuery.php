<?php

namespace app\modules\archive\query;

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
    public function byId(int $id) : PatientArchiveQuery
    {
        return $this->andWhere(['id' => $id]);
    }

    /**
     * @param  int $doctorId
     * @return PatientArchiveQuery
     */
    public function byDoctorId(int $doctorId) : PatientArchiveQuery
    {
        return $this
            ->innerJoin(['ptd' => 'patient_to_doctor'], 'ptd.patient_id = patient_archive.id')
            ->andWhere(['ptd.doctor_id' => $doctorId]);
    }

    /**
     * @param  int $revision
     * @return PatientArchiveQuery
     */
    public function byRevision(int $revision) : PatientArchiveQuery
    {
        return $this->andWhere(['revision' => $revision]);
    }
}