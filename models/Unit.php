<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property string $kode_unit
 * @property string $unit_kerja
 *
 * @property User[] $users
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_unit', 'unit_kerja'], 'required'],
            [['kode_unit'], 'unique'],
            [['kode_unit', 'unit_kerja'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_unit' => 'Kode Unit',
            'unit_kerja' => 'Unit Kerja',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['kode_unit' => 'kode_unit']);
    }
}
