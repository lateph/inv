<?php

use yii\db\Migration;

class m161227_134213_add_issue extends Migration
{
    public function up()
    {
        $this->addColumn('distribusi_barang', 'issued_by', $this->string());
        $this->addColumn('distribusi_barang', 'create_by', $this->string());
        $this->addColumn('distribusi_barang', 'create_time', $this->dateTime());
        $this->addColumn('distribusi_barang', 'date_of_order', $this->date());
    }

    public function down()
    {
        $this->dropColumn('distribusi_barang', 'issued_by');
        $this->dropColumn('distribusi_barang', 'create_by');
        $this->dropColumn('distribusi_barang', 'create_time');
        $this->dropColumn('distribusi_barang', 'date_of_order');
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
