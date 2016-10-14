<?php

use yii\db\Migration;

class m160417_214940_add_field_to_notification_settings extends Migration
{
    public function up()
    {
        $this->addColumn('notification_settings', 'show_article', $this->boolean()->notNull()->defaultValue(1));
        $this->addColumn('notification_settings', 'show_barcode', $this->boolean()->notNull()->defaultValue(1));
        $this->addColumn('notification_settings', 'show_code_client', $this->boolean()->notNull()->defaultValue(1));
    }

    public function down()
    {
        $this->dropColumn('notification_settings', 'show_article');
        $this->dropColumn('notification_settings', 'show_barcode');
        $this->dropColumn('notification_settings', 'show_code_client');
    }
}
