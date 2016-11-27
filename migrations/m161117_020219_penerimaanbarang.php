<?php
use yii\db\Schema;
use yii\db\Migration;

class m161117_020219_penerimaanbarang extends Migration
{
    public function up()
    {
        $this->createTable('penerimaan_barang', [
            'no_penerimaan' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'tanggal_penerimaan' => $this->dateTime().' NOT NULL',
            'supplier' => Schema::TYPE_STRING,
            'no_po' => Schema::TYPE_STRING,
            'pengirim' => Schema::TYPE_STRING,
            'keterangan' => Schema::TYPE_STRING,
        ]);

        

        $this->createTable('penerimaan_barang_detail', [
            'id'=>$this->primaryKey(),
            'no_penerimaan' => Schema::TYPE_STRING . ' NOT NULL',
            'kode_barang' => Schema::TYPE_STRING . ' NOT NULL',
            'qty' => $this->integer(),
            'keterangan' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey(
            'fk-kode_barang',
            'penerimaan_barang_detail',
            'kode_barang',
            'barang',
            'kode_barang'
        );

        $this->createTable('inout', [
            'id' => $this->primaryKey(),
            'idgudang' => $this->string()->notNull(),
            'kode_barang' => $this->string()->notNull(),
            'tanggal' => $this->dateTime(),
            'tipe' => $this->integer(1),
            'qty_in' => $this->integer(),
            'qty_out' => $this->integer(),
            'referensi' => $this->integer(),
            'stok' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-kode_barang-inout',
            'inout',
            'kode_barang',
            'barang',
            'kode_barang'
        );
    }

    public function down()
    {
        $this->dropTable('inout');
        $this->dropTable('penerimaan_barang_detail');
        $this->dropTable('penerimaan_barang');
        
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
