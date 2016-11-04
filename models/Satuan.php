<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "satuan".
 *
 * @property string $kode_satuan
 * @property string $satuan_barang
 * @property string $singkatan
 */
class Satuan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'satuan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_satuan', 'satuan_barang', 'singkatan'], 'required'],
            [['kode_satuan', 'satuan_barang', 'singkatan'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_satuan' => 'Kode Satuan',
            'satuan_barang' => 'Satuan Barang',
            'singkatan' => 'Singkatan',
        ];
    }
}
