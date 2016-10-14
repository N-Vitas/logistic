<?php

use yii\db\Migration;

class m160327_235004_sync_log extends Migration
{
    public function up()
    {
        $this->createTable('sync_log', [
            'id' => 'pk',
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'type' => $this->integer()->notNull()->defaultValue(1),
            'log' => $this->text(),
            'errors' => $this->integer()->notNull()->defaultValue(0),
        ]);
    }

    public function down()
    {
        $this->dropTable('sync_log');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
