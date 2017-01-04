<?php

use yii\db\Migration;

class m170104_163101_alter_column_orders extends Migration
{
    public function up()
    {
        $this->alterColumn('orders', 'id', 'INT(9) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT');  
    }

    public function down()
    {
        echo "m170104_163101_alter_column_orders cannot be reverted.\n";

        return false;
    }
}
