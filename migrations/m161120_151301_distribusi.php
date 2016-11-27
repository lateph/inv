<?php

use yii\db\Schema;
use yii\db\Migration;

class m161120_151301_distribusi extends Migration
{
    public function up()
    {
        $this->createTable('distribusi_barang', [
            'no_distribusi' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'tanggal_distribusi' => $this->dateTime().' NOT NULL',
            'kode_unit' => Schema::TYPE_STRING,
            'kode_project' => Schema::TYPE_STRING,
            'no_request' => Schema::TYPE_STRING,
            'penerima' => Schema::TYPE_STRING,
            'keterangan' => Schema::TYPE_STRING,
        ]);

         $this->addForeignKey(
            'fk-db-unit',
            'distribusi_barang',
            'kode_unit',
            'unit',
            'kode_unit'
        );

          $this->addForeignKey(
            'fk-db-project',
            'distribusi_barang',
            'kode_project',
            'project',
            'kode_project'
        );
        

        $this->createTable('distribusi_barang_detail', [
            'id'=>$this->primaryKey(),
            'no_distribusi' => Schema::TYPE_STRING . ' NOT NULL',
            'kode_barang' => Schema::TYPE_STRING . ' NOT NULL',
            'qty' => $this->integer(),
            'keterangan' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey(
            'fk-dbd-db',
            'distribusi_barang_detail',
            'no_distribusi',
            'distribusi_barang',
            'no_distribusi'
        );

        $this->addForeignKey(
            'fk-dbd-barang',
            'distribusi_barang_detail',
            'kode_barang',
            'barang',
            'kode_barang'
        );
    }

    public function down()
    {
        $this->dropTable('distribusi_barang_detail');
        $this->dropTable('distribusi_barang');
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
