<?php

use yii\db\Migration;

class m160731_112519_add_comment_to_order extends Migration
{
    public function up()
    {
        $this->addColumn('orders', 'comment', $this->text());
    }

    public function down()
    {
        $this->dropColumn('orders', 'comment');
    }
}
