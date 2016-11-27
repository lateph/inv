<?php

namespace app\models;

use Yii;
use app\components\PenerimaanBarangValidator;

/**
 * This is the model class for table "penerimaan_barang_detail".
 *
 * @property string $no_penerimaan
 * @property string $kode_barang
 * @property integer $qty
 * @property string $keterangan
 *
 * @property Barang $kodeBarang
 */
class PenerimaanBarangDetail extends \yii\db\ActiveRecord
{
    public $satuan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'penerimaan_barang_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['no_penerimaan', 'unique', 'targetAttribute' => ['no_penerimaan', 'kode_barang']],
            [['no_penerimaan', 'kode_barang','qty'], 'required'],
            [['qty'], 'integer'],
            [['satuan'], 'safe'],
            [['no_penerimaan', 'kode_barang', 'keterangan'], 'string', 'max' => 255],
            [['kode_barang'], 'exist', 'skipOnError' => true, 'targetClass' => Barang::className(), 'targetAttribute' => ['kode_barang' => 'kode_barang']],
            ['qty','default','value'=>'0'],
            ['kode_barang',PenerimaanBarangValidator::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_penerimaan' => 'No Penerimaan',
            'kode_barang' => 'Kode Barang',
            'qty' => 'Qty',
            'keterangan' => 'Keterangan',
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
