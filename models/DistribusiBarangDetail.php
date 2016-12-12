<?php

namespace app\models;

use Yii;
use app\components\PenerimaanBarangValidator;
use yii\db\Query;

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
            [['qty'], 'integer','min'=>1],
            [['qty'], 'checkStok'],
            [['satuan'], 'safe'],
            [['no_distribusi', 'kode_barang', 'keterangan'], 'string', 'max' => 255],
            [['kode_barang'], 'exist', 'skipOnError' => true, 'targetClass' => Barang::className(), 'targetAttribute' => ['kode_barang' => 'kode_barang']],
            // [['no_distribusi'], 'exist', 'skipOnError' => true, 'targetClass' => DistribusiBarang::className(), 'targetAttribute' => ['no_distribusi' => 'no_distribusi']],
             ['kode_barang',PenerimaanBarangValidator::className()]
        ];
    }

    public function checkStok($attribute, $params)
    {
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
