<?php

use yii\db\Migration;

class m160403_194827_drop_columns extends Migration
{
    public function up()
    {
        $this->dropColumn('orders', 'product_id');
        $this->dropColumn('orders', 'product_count');
    }

    public function down()
    {
    }
}
