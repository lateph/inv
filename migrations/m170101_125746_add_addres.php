<?php

use yii\db\Migration;

class m170101_125746_add_addres extends Migration
{
    public function up()
    {
        $this->addColumn('unit', 'delivery_address', $this->string(512));

    }

    public function down()
    {
        $this->dropColumn('unit', 'delivery_address');
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
