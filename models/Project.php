<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property string $kode_project
 * @property string $nama_project
 * @property string $lokasi
 * @property string $tanggal_mulai
 * @property string $tanggal_selesai
 * @property string $perusahaan
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_project', 'nama_project'], 'required'],
            [['tanggal_mulai', 'tanggal_selesai'], 'safe'],
            [['kode_project', 'nama_project', 'lokasi', 'perusahaan'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_project' => 'Kode Project',
            'nama_project' => 'Nama Project',
            'lokasi' => 'Lokasi',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'perusahaan' => 'Perusahaan',
        ];
    }
}
