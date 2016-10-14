<?php

use yii\db\Migration;

class m160327_224627_add_user_id_to_orders extends Migration
{
    public function up()
    {
        $this->addColumn('orders', 'user_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('orders', 'user_id');
    }
}
