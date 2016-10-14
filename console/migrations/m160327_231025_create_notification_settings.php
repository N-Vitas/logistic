<?php

use yii\db\Migration;

class m160327_231025_create_notification_settings extends Migration
{
    public function up()
    {
        $this->createTable('notification_settings', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'low_products' => $this->integer()->notNull()->defaultValue(20),
            'emails' => $this->text(),
            'client_notification' => $this->boolean()->notNull()->defaultValue(0),
            'client_complete_notification' => $this->boolean()->notNull()->defaultValue(0)
        ]);
    }

    public function down()
    {
        $this->dropTable('notification_settings');
    }
}
