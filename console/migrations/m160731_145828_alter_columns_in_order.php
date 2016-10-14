<?php

use yii\db\Migration;

class m160731_145828_alter_columns_in_order extends Migration
{
    public function up()
    {
        $this->alterColumn('orders', 'city_id', $this->integer());
        $this->alterColumn('orders', 'address', $this->string());
    }

    public function down()
    {
        echo "m160731_145828_alter_columns_in_order cannot be reverted.\n";

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
