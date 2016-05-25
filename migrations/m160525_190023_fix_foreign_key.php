<?php

use yii\db\Migration;

class m160525_190023_fix_foreign_key extends Migration
{
    public function up()
    {
        $this->dropForeignKey('fk_owner_user', 'organization');
        $this->addForeignKey('fk_owner_user', 'organization', 'owner_id', 'user', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        echo "m160525_190023_fix_foreign_key cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
