<?php

use yii\db\Migration;

class m160309_095143_add_delivery_date_to_orders extends Migration
{
    public function up()
    {
        $this->addColumn('orders', 'delivery_date', $this->timestamp()->notNull());
    }

    public function down()
    {
        $this->dropColumn('orders', 'delivery_date');
    }
}
