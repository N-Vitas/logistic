<?php

use yii\db\Migration;

class m161215_043740_add_column_product extends Migration
{
    public function up()
    {
        $this->addColumn('products', 'reserve', $this->integer(1)->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('products', 'reserve');
    }
}
