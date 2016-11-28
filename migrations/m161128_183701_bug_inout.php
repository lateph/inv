<?php

use yii\db\Migration;

class m161128_183701_bug_inout extends Migration
{
    public function up()
    {
        $this->alterColumn('inout','referensi',$this->string());
        $this->createIndex('index-inout-barang-gudang','inout',['idgudang','kode_barang']);
    }

    public function down()
    {
        $this->alterColumn('inout','referensi',$this->integer());
        $this->dropIndex('index-inout-barang-gudang','inout');

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
