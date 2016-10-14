<?php

use yii\db\Migration;

class m160308_205331_create_orders extends Migration
{
    public function up()
    {
        $this->createTable('orders', [
            'id' => $this->primaryKey(),
            'number' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'client_id' => $this->integer()->notNull(),
            'client_name' => $this->string()->notNull(),
            'address' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
            'payment_type' => $this->string()->notNull(),
            'product_count' => $this->integer()->notNull(),
            'price' => $this->float()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('orders');
    }
}
