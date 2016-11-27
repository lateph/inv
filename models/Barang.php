<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barang".
 *
 * @property string $kode_barang
 * @property string $kode_kategori
 * @property string $nama_barang
 * @property string $kode_satuan
 * @property string $deskripsi
 * @property integer $stock_warning
 *
 * @property KategoriBarang $kodeKategori
 * @property Satuan $kodeSatuan
 */
class Barang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'barang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_barang','kode_kategori','kode_satuan'], 'required'],
            [['deskripsi'], 'string'],
            [['stock_warning'], 'integer'],
            [['kode_barang', 'kode_kategori', 'nama_barang', 'kode_satuan'], 'string', 'max' => 255],
            [['kode_kategori'], 'exist', 'skipOnError' => true, 'targetClass' => KategoriBarang::className(), 'targetAttribute' => ['kode_kategori' => 'kode_kategori']],
            [['kode_satuan'], 'exist', 'skipOnError' => true, 'targetClass' => Satuan::className(), 'targetAttribute' => ['kode_satuan' => 'kode_satuan']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_barang' => 'Kode Barang',
            'kode_kategori' => 'Kategori',
            'nama_barang' => 'Nama Barang',
            'kode_satuan' => 'Satuan',
            'deskripsi' => 'Deskripsi',
            'stock_warning' => 'Stock Warning',
            'tampil_stok_kosong' => 'Tampilkan Stok Kosong',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategori()
    {
        return $this->hasOne(KategoriBarang::className(), ['kode_kategori' => 'kode_kategori']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(Satuan::className(), ['kode_satuan' => 'kode_satuan']);
    }

    public function getkodenama()
    {
            return $this->kode_barang.' - '.$this->nama_barang;
    }

    public function fields()
    {   
        $fields = parent::fields();
        $fields[] = 'satuan';
        return $fields;
    }

    public function getInout()
    {
        return $this->hasMany(Inout::className(), ['kode_barang' => 'kode_barang']);
    }
}
