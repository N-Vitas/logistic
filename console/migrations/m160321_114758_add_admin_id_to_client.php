<?php

use yii\db\Migration;

class m160321_114758_add_admin_id_to_client extends Migration
{
    public function up()
    {
        $this->addColumn('clients', 'admin_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn('clients', 'admin_id');
    }
}
