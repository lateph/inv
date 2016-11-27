<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distribusi_barang".
 *
 * @property string $no_distribusi
 * @property string $tanggal_distribusi
 * @property string $kode_unit
 * @property string $kode_project
 * @property string $no_request
 * @property string $penerima
 * @property string $keterangan
 *
 * @property Unit $kodeUnit
 * @property Unit $kodeUnit0
 * @property DistribusiBarangDetail[] $distribusiBarangDetails
 */
class DistribusiBarang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'distribusi_barang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_distribusi', 'tanggal_distribusi'], 'required'],
            [['tanggal_distribusi'], 'safe'],
            [['no_distribusi', 'kode_unit', 'kode_project', 'no_request', 'penerima', 'keterangan'], 'string', 'max' => 255],
            [['kode_unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['kode_unit' => 'kode_unit']],
            [['kode_unit'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::className(), 'targetAttribute' => ['kode_unit' => 'kode_unit']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'no_distribusi' => 'No Distribusi',
            'tanggal_distribusi' => 'Tanggal Distribusi',
            'kode_unit' => 'Kode Unit',
            'kode_project' => 'Kode Project',
            'no_request' => 'No Request',
            'penerima' => 'Penerima',
            'keterangan' => 'Keterangan',
            'tgl1' => 'Periode Distribusi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::className(), ['kode_unit' => 'kode_unit']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['kode_project' => 'kode_project']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails()
    {
        return $this->hasMany(DistribusiBarangDetail::className(), ['no_distribusi' => 'no_distribusi']);
    }
}
