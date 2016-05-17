<?php

use yii\db\Migration;

class m160517_175301_add_created_at_to_test_table extends Migration
{
    public function up()
    {
        $this->addColumn('test', 'created_at', $this->dateTime());
    }

    public function down()
    {
        $this->dropColumn('test', 'created_at');
    }
}
