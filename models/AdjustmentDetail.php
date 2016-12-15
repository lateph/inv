<?php

namespace app\models;
use app\components\PenerimaanBarangValidator;
use yii\db\Query;

use Yii;

/**
 * This is the model class for table "adjustment_detail".
 *
 * @property integer $id
 * @property string $no_adjustment
 * @property string $kode_barang
 * @property integer $qty
 * @property string $keterangan
 *
 * @property Adjustment $noAdjustment
 */
class AdjustmentDetail extends \yii\db\ActiveRecord
{
    public $satuan;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adjustment_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_adjustment', 'kode_barang'], 'required'],
            [['qty'], 'integer','min'=>1],
            [['satuan'], 'safe'],
            [['qty'], 'checkStok'],
            [['no_adjustment', 'kode_barang', 'keterangan'], 'string', 'max' => 255],
            // [['no_adjustment'], 'exist', 'skipOnError' => true, 'targetClass' => Adjustment::className(), 'targetAttribute' => ['no_adjustment' => 'no_adjustment']],
            [['kode_barang'], 'exist', 'skipOnError' => true, 'targetClass' => Barang::className(), 'targetAttribute' => ['kode_barang' => 'kode_barang']],
             ['kode_barang',PenerimaanBarangValidator::className()]

        ];
    }

    public function checkStok($attribute, $params)
    {
        if($this->kondisi == '1' or $this->kondisi == '3'){
            $query = new Query;
            // compose the query
            $tot = $query->select('sum(qty_in - qty_out)')
                ->from('inout')
                ->where(['=','idgudang','G001'])
                ->andWhere(['=','kode_barang',$this->kode_barang])
                ->scalar();

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand('select * from barang where kode_barang = :kb FOR UPDATE', [':kb' => $this->kode_barang]);
            $result = $command->queryAll();

            if ($tot < $this->qty) {
                $this->addError('qty', 'Qty melebihi stok.');
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_adjustment' => 'No Adjustment',
            'kode_barang' => 'Kode Barang',
            'qty' => 'Qty',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdjustment()
    {
        return $this->hasOne(Adjustment::className(), ['no_adjustment' => 'no_adjustment']);
    }

    public function getBarang()
    {
        return $this->hasOne(Barang::className(), ['kode_barang' => 'kode_barang']);
    }
}
