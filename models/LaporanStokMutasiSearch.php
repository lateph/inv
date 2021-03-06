<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Barang;
use app\models\Inout;

/**
 * LaporanBarangSearch represents the model behind the search form about `app\models\Barang`.
 */
class LaporanStokMutasiSearch extends Barang
{
    public $tampil_stok_kosong;
    public $stok;
    public $kode_unit;
    public $qty_in;
    public $qty_out;
    public $referensi;
    public $id;
    public $tipe;
    public $tanggal;
    public $tipeIO;

    public $tgl1;
    public $tgl2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_barang', 'kode_kategori', 'kode_satuan', 'deskripsi','tampil_stok_kosong','nama_barang','stock_warning','tipeIO','referensi','tgl1','tgl2'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $attr = parent::attributeLabels();
        $attr['tgl1'] ='Periode Mutasi';
        $attr['tipeIO'] ='Tipe';
        return $attr;
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LaporanStokMutasiSearch::find()->select('barang.*,unit_gudang.kode_unit,`inout`.id,`inout`.qty_in,`inout`.qty_out,`inout`.referensi,`inout`.stok,`inout`.tipe,`inout`.tanggal');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->indexBy = function($row){
            return $row['id'];
        };

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        $query->join('join','unit_gudang');

        $query->joinWith(['satuan','kategori']);
        $query->join('inner join','inout','`inout`.kode_barang = barang.kode_barang and `inout`.idgudang = unit_gudang.kode_unit');

        $query->orderBy('`inout`.`id` asc');

        if($this->tipeIO == 'in'){
            $query->andWhere('`inout`.qty_in > `inout`.qty_out');
        }
        if($this->tipeIO == 'out'){
            $query->andWhere('`inout`.qty_in < `inout`.qty_out');
        }

        if($this->tgl2)
            $query->andFilterWhere(['<=', 'tanggal', $this->tgl2.' 23:59']);

        // 
        // $query->groupBy(['barang.kode_barang', 'unit_gudang.kode_unit']);

        $query->andFilterWhere(['=', 'barang.kode_barang', $this->kode_barang])
            ->andFilterWhere(['=', 'barang.kode_kategori', $this->kode_kategori])
            ->andFilterWhere(['=', '`inout`.tipe', $this->referensi])
            ->andFilterWhere(['=', 'barang.kode_satuan', $this->kode_satuan])
            ->andFilterWhere(['=', 'barang.stock_warning', $this->stock_warning])
            ->andFilterWhere(['=', 'unit_gudang.kode_unit','G001'])
            ->andFilterWhere(['like', 'barang.deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'barang.nama_barang', $this->nama_barang])
            ->andFilterWhere(['>=', 'tanggal', $this->tgl1]);


        // $posts = $dataProvider->getModels();

        // print_r($query->all());
        // exit;

        return $dataProvider;
    }

    
}
