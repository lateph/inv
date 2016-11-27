<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "adjustment".
 *
 * @property string $no_adjustment
 * @property string $tanggal_adjustment
 * @property string $kode_barang
 * @property string $kondisi
 * @property integer $qty
 * @property string $keterangan
 * @property string $kode_unit
 * @property string $penanggung_jawab
 *
 * @property Barang $kodeBarang
 */
class Adjustment extends \yii\db\ActiveRecord
{
    const pilihanKondisi = ['1'=>'Berkurang','2'=>'Bertambah','3'=>'Service Maintenance Out','4'=>'Service Maintenance In'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adjustment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_adjustment'], 'unique'],
            [['no_adjustment', 'tanggal_adjustment', 'kode_barang', 'kondisi', 'qty', 'keterangan', 'penanggung_jawab'], 'required'],
            [['tanggal_adjustment'], 'safe'],
            [['qty'], 'integer'],
            [['no_adjustment', 'kode_barang', 'kondisi', 'keterangan', 'kode_unit', 'penanggung_jawab'], 'string', 'max' => 255],
            [['kode_barang'], 'exist', 'skipOnError' => true, 'targetClass' => Barang::className(), 'targetAttribute' => ['kode_barang' => 'kode_barang']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_adjustment' => 'No Adjustment',
            'tanggal_adjustment' => 'Tanggal Adjustment',
            'kode_barang' => 'Kode Barang',
            'kondisi' => 'Kondisi',
            'qty' => 'Qty',
            'keterangan' => 'Keterangan',
            'kode_unit' => 'Kode Unit',
            'penanggung_jawab' => 'Penanggung Jawab',
            'tgl1' => 'Periode Penerimaan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['kode_barang' => 'kode_barang']);
    }
}
