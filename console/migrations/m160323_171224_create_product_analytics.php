<?php

use yii\db\Migration;

class m160323_171224_create_product_analytics extends Migration
{
    public function up()
    {
        $this->createTable('product_analytics', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'decrease' => $this->integer()->notNull(),
            'increase' => $this->integer()->notNull(),
            'created_at' => $this->date()
        ]);
    }

    public function down()
    {
        $this->dropTable('product_analytics');
    }
}
