<?php

use yii\db\Migration;

class m161215_135848_add_kondisi_detaiadjustment extends Migration
{
    public function up()
    {
        $this->addColumn('adjustment_detail', 'kondisi', $this->string()->notNull());
    }

    public function down()
    {
        $this->dropColumn('adjustment_detail', 'kondisi');
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
