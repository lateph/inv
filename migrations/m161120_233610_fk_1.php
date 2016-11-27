<?php

use yii\db\Migration;

class m161120_233610_fk_1 extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'fk-pbb-pb',
            'penerimaan_barang_detail',
            'no_penerimaan',
            'penerimaan_barang',
            'no_penerimaan'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-pbb-pb',
            'penerimaan_barang_detail'
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
