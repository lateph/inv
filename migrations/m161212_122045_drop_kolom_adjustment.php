<?php

use yii\db\Migration;

class m161212_122045_drop_kolom_adjustment extends Migration
{
    public function up()
    {
        $this->dropForeignKey(
            'fk-a-b',
            'adjustment'
        );

        $this->dropColumn('adjustment', 'kode_barang');
        $this->dropColumn('adjustment', 'qty');
    }

    public function down()
    {
        $this->addColumn('adjustment', 'kode_barang', $this->string()->notNull());
        $this->addColumn('adjustment', 'qty', $this->integer()->notNull());
    
        $this->addForeignKey(
            'fk-a-b',
            'adjustment',
            'kode_barang',
            'barang',
            'kode_barang'
        );
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
