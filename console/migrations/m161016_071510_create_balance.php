<?php

use yii\db\Migration;

class m161016_071510_create_balance extends Migration
{
    public function up()
    {
        $this->createTable('balance', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(11)->notNull()->unique(),
            'balance' => $this->string()->notNull(),
            'min_balance' => $this->integer(11)->notNull()->defaultValue(10),
        ]);
    }

    public function down()
    {
        $this->dropTable('balance');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
