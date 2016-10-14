<?php

use yii\db\Migration;

class m160327_235046_add_exported_to_orders extends Migration
{
    public function up()
    {
        $this->addColumn('orders', 'exported', $this->boolean()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('orders', 'exported');
    }
}
