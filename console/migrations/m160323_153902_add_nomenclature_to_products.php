<?php

use yii\db\Migration;

class m160323_153902_add_nomenclature_to_products extends Migration
{
    public function up()
    {
        $this->addColumn('products', 'nomenclature', \yii\db\mysql\Schema::TYPE_STRING);
    }

    public function down()
    {
    }
}
