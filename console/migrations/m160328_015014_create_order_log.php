<?php

use yii\db\Migration;

class m160328_015014_create_order_log extends Migration
{
    public function up()
    {
        $this->createTable('order_log', [
            'id' => $this->primaryKey(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'order_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'status_date' => $this->timestamp()->notNull()->defaultValue(0)
        ]);

        $this->addColumn('orders', 'updated_at', $this->timestamp()->notNull());
    }

    public function down()
    {
        $this->dropTable('order_log');
        $this->dropColumn('orders', 'updated_at');
    }
}
