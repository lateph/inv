<?php
use yii\db\Schema;

use yii\db\Migration;

class m161105_113233_add_tables extends Migration
{
    public function up()
    {
        $this->createTable('project', [
            'kode_project' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'nama_project' => Schema::TYPE_STRING. ' NOT NULL',
            'lokasi' => Schema::TYPE_STRING,
            'tanggal_mulai' => $this->date(),
            'tanggal_selesai' => $this->date(),
            'perusahaan' => Schema::TYPE_STRING,
        ]);

        $this->createTable('unit', [
            'kode_unit' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'unit_kerja' => Schema::TYPE_STRING. ' NOT NULL'
        ]);

        $this->createTable('user', [
            'kode_user' => Schema::TYPE_STRING . ' NOT NULL PRIMARY KEY',
            'username' => Schema::TYPE_STRING. ' NOT NULL UNIQUE',
            'password' => Schema::TYPE_STRING,
            'nama' => Schema::TYPE_STRING,
            'kode_unit' => Schema::TYPE_STRING,
            'hak_akses' => Schema::TYPE_STRING,
        ]);

        $this->addForeignKey(
            'fk-kode_unit',
            'user',
            'kode_unit',
            'unit',
            'kode_unit'
        );
    }

    public function down()
    {
        $this->dropTable('user');
        $this->dropTable('unit');
        $this->dropTable('project');
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
