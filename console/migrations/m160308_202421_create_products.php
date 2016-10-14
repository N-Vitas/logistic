<?php

use yii\db\Migration;

class m160308_202421_create_products extends Migration
{
    public function up()
    {
        $this->createTable('products', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'article' => $this->string()->notNull(),
            'barcode' => $this->string()->notNull(),
            'balance' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    public function down()
    {
        $this->dropTable('products');
    }
}
