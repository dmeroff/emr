<?php

use yii\db\Migration;

class m160515_163812_init_archive extends Migration
{
    public function up()
    {
        $this->execute(file_get_contents(__DIR__ . '/init_archive.sql'));
    }

   public function down()
   {
       $this->execute('SET FOREIGN_KEY_CHECKS=0;');

       $this->dropTable('organization_archive');
       $this->dropTable('patient_archive');

       $this->execute('SET FOREIGN_KEY_CHECKS=1;');
   }
}
