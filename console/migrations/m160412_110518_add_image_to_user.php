<?php

use yii\db\Migration;

class m160412_110518_add_image_to_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'image', $this->string());
    }

    public function down()
    {
        $this->dropColumn('user', 'image');
    }
}
