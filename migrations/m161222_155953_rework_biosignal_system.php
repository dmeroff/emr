<?php

use yii\db\Migration;

class m161222_155953_rework_biosignal_system extends Migration
{
    public function up()
    {
        $this->addColumn('biosignal', 'type_id', $this->integer()->notNull());
        $this->addColumn('biosignal', 'text_data', $this->text());

        $this->createTable('biosignal_type', [
            'id' => $this->primaryKey(),
            'description' => $this->text(),
        ]);

        $this->createTable('biosignal_timestamp', [
            'id' => $this->primaryKey(),
            'biosignal_id' => $this->integer(),
            'timestamp' => $this->timestamp(),
            'name' => $this->string(),
            'description' => $this->text(),
            'doctor_id' => $this->integer(),
        ]);

        $this->addForeignKey('fk_biosignal_biosignal_type', 'biosignal', 'type_id', 'biosignal_type', 'id');
        $this->addForeignKey('fk_biosignal_timestamp_biosignal', 'biosignal_timestamp', 'biosignal_id', 'biosignal', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('fk_biosignal_biosignal_type', 'biosignal');
        $this->dropForeignKey('fk_biosignal_timestamp_biosignal', 'biosignal_timestamp');

        $this->dropColumn('biosignal', 'type_id');
        $this->dropColumn('biosignal', 'text_data');

        $this->dropTable('biosignal_type');
        $this->dropTable('biosignal_timestamp');
    }
}
