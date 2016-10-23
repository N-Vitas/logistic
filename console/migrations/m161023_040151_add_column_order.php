<?php

use yii\db\Migration;

class m161023_040151_add_column_order extends Migration
{
    public function up()
    {
        $this->addColumn('orders', 'status_delivery', $this->integer(1)->notNull()->defaultValue(0));
        $this->addColumn('orders', 'status_payments', $this->integer(1)->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('orders', 'status_delivery');
        $this->dropColumn('orders', 'status_payments');
    }
}
