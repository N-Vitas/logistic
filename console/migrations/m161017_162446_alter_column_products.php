<?php

use yii\db\Migration;

class m161017_162446_alter_column_products extends Migration
{
    public function up()
    {
        $this->alterColumn('products', 'balance', $this->char(18));    
    }

    public function down()
    {
        echo "m161017_162446_alter_column_products cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }char(18)
    */
}
