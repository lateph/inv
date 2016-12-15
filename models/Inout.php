<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inout".
 *
 * @property integer $id
 * @property string $idgudang
 * @property string $kode_barang
 * @property string $tanggal
 * @property integer $tipe
 * @property integer $qty_in
 * @property integer $qty_out
 * @property integer $referensi
 * @property integer $stok
 *
 * @property Barang $kodeBarang
 */
class Inout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'inout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idgudang', 'kode_barang'], 'required'],
            [['tanggal'], 'safe'],
            [['tipe', 'qty_in', 'qty_out', 'referensi', 'stok'], 'integer'],
            [['idgudang', 'kode_barang'], 'string', 'max' => 255],
            [['kode_barang'], 'exist', 'skipOnError' => true, 'targetClass' => Barang::className(), 'targetAttribute' => ['kode_barang' => 'kode_barang']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idgudang' => 'Idgudang',
            'kode_barang' => 'Kode Barang',
            'tanggal' => 'Tanggal',
            'tipe' => 'Tipe',
            'qty_in' => 'Qty In',
            'qty_out' => 'Qty Out',
            'referensi' => 'Referensi',
            'stok' => 'Stok',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeBarang()
    {
        return $this->hasOne(Barang::className(), ['kode_barang' => 'kode_barang']);
    }

    public static function getCurrentStok($idgudang,$kode_barang){
        return Inout::find()->andFilterWhere(['=','idgudang',$idgudang])->andFilterWhere(['=','kode_barang',$kode_barang])->sum("qty_in - qty_out");
    }

    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['kode_barang' => 'kode_barang']);
    }

    public function getDistribusi()
    {
        return $this->hasOne(DistribusiBarang::className(), ['no_distribusi' => 'referensi']);
    }
}
