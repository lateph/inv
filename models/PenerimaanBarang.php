<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "penerimaan_barang".
 *
 * @property string $no_penerimaan
 * @property string $tanggal_penerimaan
 * @property string $supplier
 * @property string $no_po
 * @property string $pengirim
 * @property string $keterangan
 */
class PenerimaanBarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'penerimaan_barang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_penerimaan'], 'unique'],
            [['no_penerimaan', 'tanggal_penerimaan'], 'required'],
            [['tanggal_penerimaan'], 'safe'],
            [['tanggal_penerimaan'], 'default','value'=>date('Y-m-d H:i')],
            [['no_penerimaan', 'supplier', 'no_po', 'pengirim', 'keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_penerimaan' => 'No Penerimaan',
            'tanggal_penerimaan' => 'Tanggal Penerimaan',
            'supplier' => 'Supplier',
            'no_po' => 'No Po',
            'pengirim' => 'Pengirim',
            'keterangan' => 'Keterangan',
            'tgl1' => 'Periode Penerimaan',
        ];
    }

    public function getDetails()
    {
        return $this->hasMany(PenerimaanBarangDetail::className(), ['no_penerimaan' => 'no_penerimaan']);
    }
}
