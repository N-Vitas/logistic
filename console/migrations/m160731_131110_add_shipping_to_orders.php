<?php

use yii\db\Migration;

class m160731_131110_add_shipping_to_orders extends Migration
{
    public function up()
    {
        $this->addColumn('orders', 'no_shipping', $this->boolean()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('orders', 'no_shipping');
    }
}
