<?php

use yii\db\Migration;

class m160412_150935_alter_orders extends Migration
{
    public function up()
    {
        $this->alterColumn('orders', 'id', $this->integer(7)->unsigned() . ' ZEROFILL NOT NULL');
    }

    public function down()
    {
        echo "m160412_150935_alter_orders cannot be reverted.\n";

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
