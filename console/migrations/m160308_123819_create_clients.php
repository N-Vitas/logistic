<?php

use yii\db\Migration;

class m160308_123819_create_clients extends Migration
{
    public function up()
    {
        $this->createTable('clients', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'legal_name' => $this->string()->notNull(),
            'is_id' => $this->string()->notNull()->unique(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
        ]);
    }

    public function down()
    {
        $this->dropTable('clients');
    }
}
