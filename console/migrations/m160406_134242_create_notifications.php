<?php

use yii\db\Migration;

class m160406_134242_create_notifications extends Migration
{
    public function up()
    {
        $this->createTable('notifications', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'user_id' => $this->integer(),
            'text' => $this->string(),
            'is_read' => $this->boolean()->notNull()->defaultValue(0),
        ]);
    }

    public function down()
    {
        $this->dropTable('notifications');
    }
}
