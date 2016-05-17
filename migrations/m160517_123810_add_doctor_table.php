<?php

use yii\db\Migration;

class m160517_123810_add_doctor_table extends Migration
{
    public function up()
    {
        $this->createTable('doctor', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer()->notNull(),
            'organization_id' => $this->integer(),
            'name'            => $this->string(),
            'patronymic'      => $this->string(),
            'surname'         => $this->string(),
        ]);
        
        $this->dropForeignKey('fk_patient_to_doctor_doctor', 'patient_to_doctor');
        $this->addForeignKey('fk_patient_to_doctor_doctor', 'patient_to_doctor', 'doctor_id', 'doctor', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('doctor');
    }
}
