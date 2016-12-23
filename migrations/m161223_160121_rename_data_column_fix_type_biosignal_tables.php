<?php

use yii\db\Migration;

class m161223_160121_rename_data_column_fix_type_biosignal_tables extends Migration
{
    public function up()
    {
        $this->renameColumn('biosignal', 'data', 'binary_data');
        $this->alterColumn('biosignal_timestamp', 'timestamp', $this->time());
    }

    public function down()
    {
        echo "m161223_160121_rename_data_column_fix_type_biosignal_tables cannot be reverted.\n";

        return false;
    }
}
