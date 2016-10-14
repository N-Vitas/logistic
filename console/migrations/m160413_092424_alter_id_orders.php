<?php

use yii\db\Migration;

class m160413_092424_alter_id_orders extends Migration
{
    public function up()
    {
        $this->truncateTable('order_item');
        $this->truncateTable('orders');
        $this->alterColumn('orders', 'id', $this->integer(7)->unsigned() . ' ZEROFILL NOT NULL AUTO_INCREMENT');
    }

    public function down()
    {
        echo "m160413_092424_alter_id_orders cannot be reverted.\n";

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
