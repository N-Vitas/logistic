<?php

use yii\db\Migration;

class m160323_065338_add_is_active_to_clients extends Migration
{
    public function up()
    {
        $this->addColumn('clients', 'is_active', $this->integer()->notNull()->defaultValue(1));
    }

    public function down()
    {
        $this->dropColumn('clients', 'is_active');
    }
}
