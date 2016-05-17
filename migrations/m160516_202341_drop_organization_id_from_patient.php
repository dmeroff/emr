<?php

use yii\db\Migration;

class m160516_202341_drop_organization_id_from_patient extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_patient_organization', 'patient');
        $this->dropColumn('patient', 'organization_id');
        try {
            $this->dropColumn('patient_archive', 'organization_id');    
        } catch (Throwable $e) {
        }
    }

    public function down()
    {
        $this->addColumn('patient_archive', 'organization_id', $this->integer());
        $this->addColumn('patient', 'organization_id', $this->integer());
        $this->addForeignKey('fk_patient_organization', 'patient', 'organization_id', 'organization', 'id', 'SET NULL', 'RESTRICT');
    }
}
