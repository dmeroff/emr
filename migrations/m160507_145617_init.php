<?php

use yii\db\Migration;

class m160507_145617_init extends Migration
{
    public function up()
    {
        $this->execute(file_get_contents(__DIR__ . '/init.sql'));
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS=0;');

        $this->dropTable('user');
        $this->dropTable('user_invite');
        $this->dropTable('user_token');
        $this->dropTable('patient');
        $this->dropTable('organization');
        $this->dropTable('biosignal');

        $this->execute('SET FOREIGN_KEY_CHECKS=1;');
    }
}
