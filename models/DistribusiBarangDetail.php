<?php

namespace app\models;

use Yii;
use app\components\PenerimaanBarangValidator;

/**
 * This is the model class for table "distribusi_barang_detail".
 *
 * @property integer $id
 * @property string $no_distribusi
 * @property string $kode_barang
 * @property integer $qty
 * @property string $keterangan
 *
 * @property Barang $kodeBarang
 * @property DistribusiBarang $noDistribusi
 */
class DistribusiBarangDetail extends \yii\db\ActiveRecord
{
    public $satuan;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distribusi_barang_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_distribusi', 'kode_barang'], 'required'],
            [['qty'], 'integer'],
            [['satuan'], 'safe'],
            [['no_distribusi', 'kode_barang', 'keterangan'], 'string', 'max' => 255],
            [['kode_barang'], 'exist', 'skipOnError' => true, 'targetClass' => Barang::className(), 'targetAttribute' => ['kode_barang' => 'kode_barang']],
            // [['no_distribusi'], 'exist', 'skipOnError' => true, 'targetClass' => DistribusiBarang::className(), 'targetAttribute' => ['no_distribusi' => 'no_distribusi']],
             ['kode_barang',PenerimaanBarangValidator::className()]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_distribusi' => 'No Distribusi',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoDistribusi()
    {
        return $this->hasOne(DistribusiBarang::className(), ['no_distribusi' => 'no_distribusi']);
    }
}
