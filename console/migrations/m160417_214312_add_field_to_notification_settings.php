<?php

use yii\db\Migration;

class m160417_214312_add_field_to_notification_settings extends Migration
{
    public function up()
    {
        $this->addColumn('notification_settings', 'address', $this->string());
        $this->addColumn('notification_settings', 'phone', $this->string());
        $this->addColumn('notification_settings', 'email', $this->string());
        $this->addColumn('notification_settings', 'name', $this->string());
    }

    public function down()
    {
        $this->dropColumn('notification_settings', 'address');
        $this->dropColumn('notification_settings', 'phone');
        $this->dropColumn('notification_settings', 'email');
        $this->dropColumn('notification_settings', 'name');
    }
}
