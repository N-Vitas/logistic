<?php

use yii\db\Migration;

class m160426_185642_create_cities_table extends Migration
{
    public function up()
    {
        $this->createTable('cities', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()
        ]);
    }

    public function down()
    {
        $this->dropTable('cities');
    }
}
