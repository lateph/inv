<?php

use yii\db\Migration;

class m161129_034042_add_admin extends Migration
{
    public function up()
    {
         $this->insert('user', [
            'kode_user' => 'AD01',
            'username' => 'admin',
            'password' => md5('admin'),
            'nama' => 'admin',
            'kode_unit' => null,
            'hak_akses' => 'AD',
        ]);
    }

    public function down()
    {
        $this->insert('user', [
            'kode_user' => 'AD01'
        ]);
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
