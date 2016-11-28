<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kategori_barang".
 *
 * @property string $kode_kategori
 * @property string $kategori_barang
 */
class KategoriBarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kategori_barang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_kategori', 'kategori_barang'], 'required'],
            [['kode_kategori'], 'unique'],
            [['kode_kategori', 'kategori_barang'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_kategori' => 'Kode Kategori',
            'kategori_barang' => 'Kategori Barang',
        ];
    }
}
