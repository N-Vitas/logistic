<?php

use yii\db\Migration;

class m160328_014258_get_rid_of_number_in_orders extends Migration
{
    public function up()
    {
        $this->dropColumn('orders', 'number');
    }

    public function down()
    {
        echo "m160328_014258_get_rid_of_number_in_orders cannot be reverted.\n";

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
