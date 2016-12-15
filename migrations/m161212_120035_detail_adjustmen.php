<?php

use yii\db\Migration;

class m161212_120035_detail_adjustmen extends Migration
{
    public function up()
    {
         $this->createTable('adjustment_detail', [
            'id'=>$this->primaryKey(),
            'no_adjustment' => $this->string()->notNull(),
            'kode_barang' => $this->string()->notNull(),
            'qty' => $this->integer(),
            'keterangan' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk-ad-a',
            'adjustment_detail',
            'no_adjustment',
            'adjustment',
            'no_adjustment'
        );
    }

    public function down()
    {
        $this->dropTable('adjustment_detail');
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
