<?php
use yii\db\Schema;
use yii\db\Migration;

class m161103_225951_create_satuan extends Migration
{
    public function up()
    {
        $this->createTable('satuan', [
            'kode_satuan' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'satuan_barang' => Schema::TYPE_STRING . ' NOT NULL',
            'singkatan' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('satuan');
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
