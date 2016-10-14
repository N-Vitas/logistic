<?php

use yii\db\Migration;

class m160309_084404_add_status_to_orders extends Migration
{
    public function up()
    {
        $this->addColumn(
            'orders', 'status', $this->integer()->notNull()->defaultValue(1)
        );
    }

    public function down()
    {
        $this->dropColumn('orders', 'status');
    }
}
