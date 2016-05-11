<?php

use yii\db\Migration;

class m160511_194831_fix_foreign_key extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_referrer_user', 'user_invite');
    }

    public function down()
    {
        $this->addForeignKey('fk_referrer_user', 'user_invite', 'referrer_id', 'user', 'id', 'CASCADE', 'RESTRICT');
    }
}
