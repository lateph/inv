<?php
use yii\db\Schema;
use yii\db\Migration;

class m161104_040932_create_kategori extends Migration
{
    public function up()
    {
        $this->createTable('kategori_barang', [
            'kode_kategori' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'kategori_barang' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('kategori_barang');
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
