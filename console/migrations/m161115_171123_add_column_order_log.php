<?php

use yii\db\Migration;

class m161115_171123_add_column_order_log extends Migration
{
    public function up()
    {
        $this->addColumn('order_log', 'status_payments', $this->integer(1)->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('order_log', 'status_payments');

        return false;
    }
}
