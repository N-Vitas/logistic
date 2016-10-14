<?php

use yii\db\Migration;

class m160412_044741_add_code_client_to_products extends Migration
{
    public function up()
    {
        $this->addColumn('products', 'code_client', $this->string());
    }

    public function down()
    {
        $this->dropColumn('products', 'code_client');
    }
}
