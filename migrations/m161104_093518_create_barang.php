<?php
use yii\db\Schema;
use yii\db\Migration;

class m161104_093518_create_barang extends Migration
{
     public function up()
    {
        $this->createTable('barang', [
            'kode_barang' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'kode_kategori' => Schema::TYPE_STRING,
            'nama_barang' => Schema::TYPE_STRING,
            'kode_satuan' => Schema::TYPE_STRING,
            'deskripsi' => Schema::TYPE_TEXT,
            'stock_warning' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-kategori_barang',
            'barang',
            'kode_kategori',
            'kategori_barang',
            'kode_kategori'
        );

        $this->addForeignKey(
            'fk-satuan',
            'barang',
            'kode_satuan',
            'satuan',
            'kode_satuan'
        );
    }

    public function down()
    {
        $this->dropTable('barang');
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
