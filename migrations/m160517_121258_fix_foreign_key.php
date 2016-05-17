<?php

use yii\db\Migration;

class m160517_121258_fix_foreign_key extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_patient_to_doctor_patient', 'patient_to_doctor');
        $this->addForeignKey('fk_patient_to_doctor_patient', 'patient_to_doctor', 'patient_id', 'patient', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        echo "m160517_121258_fix_foreign_key cannot be reverted.\n";

        return false;
    }
}
