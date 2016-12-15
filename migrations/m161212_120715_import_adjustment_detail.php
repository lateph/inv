<?php

use yii\db\Migration;
use app\models\Adjustment;
use app\models\AdjustmentDetail;

class m161212_120715_import_adjustment_detail extends Migration
{
    public function up()
    {
        $adjustments = Adjustment::find()->all();
        foreach ($adjustments as $key => $value) {
            $ad = new AdjustmentDetail();
            $ad->no_adjustment = $value->no_adjustment;
            $ad->kode_barang = $value->kode_barang;
            $ad->qty = $value->qty;
            $ad->keterangan = $value->keterangan;
            $ad->save(false);
        }
    }

    public function down()
    {
        $this->delete('adjustment_detail');
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
