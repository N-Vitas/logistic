<?php

use yii\db\Migration;

class m160402_075535_create_order_item extends Migration
{
    public function safeUp()
    {
        $this->createTable('order_item', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'order_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->notNull()->defaultValue(1),
            'price' => $this->integer()->notNull()
        ]);

    }

    public function down()
    {
        $this->dropTable('order_item');
    }
}
