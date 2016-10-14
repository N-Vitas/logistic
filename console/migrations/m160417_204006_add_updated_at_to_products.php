<?php

use yii\db\Migration;

class m160417_204006_add_updated_at_to_products extends Migration
{
    public function up()
    {
        $this->addColumn('products', 'updated_at', $this->timestamp()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('products', 'updated_at');
    }
}
