<?php

use yii\db\Migration;

class m160323_160158_add_city_to_products extends Migration
{
    public function up()
    {
        $this->addColumn('orders', 'city_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('orders', 'city_id');
    }
}
