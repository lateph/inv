<?php

use yii\db\Migration;
use yii\db\Schema;
class m161121_031345_adjustmen extends Migration
{
    public function up()
    {
        $this->createTable('adjustment', [
            'no_adjustment' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'tanggal_adjustment' => $this->dateTime().' NOT NULL',
            'kode_barang' =>  $this->string()->notNull(),
            'kondisi' =>  $this->string()->notNull(),
            'qty' => $this->integer()->notNull(),
            'keterangan' =>  $this->string()->notNull(),
            'kode_unit' => $this->string(),
            'penanggung_jawab' =>  $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-a-b',
            'adjustment',
            'kode_barang',
            'barang',
            'kode_barang'
        );
    }

    public function down()
    {
        $this->dropTable('adjustment');
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
