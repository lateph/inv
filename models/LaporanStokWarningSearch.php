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
class LaporanStokWarningSearch extends Barang
{
    public $tampil_stok_kosong;
    public $stok;
    public $kode_unit;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_barang', 'kode_kategori', 'kode_satuan', 'deskripsi','tampil_stok_kosong','nama_barang'], 'safe'],
        ];
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
        $query = LaporanStokWarningSearch::find()->select('barang.*,unit_gudang.kode_unit, sum(qty_in - qty_out) as stok');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->indexBy = function($row){
            return $row['kode_barang'] .'-'. $row['kode_unit'];
        };

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->tampil_stok_kosong == 1){
            $query->andFilterWhere(['>', 'stok',0]);
        }

        
        $query->join('join','unit_gudang');

        $query->joinWith(['satuan','kategori']);
        $query->join('left join','inout','`inout`.kode_barang = barang.kode_barang and `inout`.idgudang = unit_gudang.kode_unit');
        // 
        $query->groupBy(['barang.kode_barang', 'unit_gudang.kode_unit']);

        $query->andFilterWhere(['=', 'barang.kode_barang', $this->kode_barang])
            ->andFilterWhere(['=', 'barang.kode_kategori', $this->kode_kategori])
            ->andFilterWhere(['=', 'barang.kode_satuan', $this->kode_satuan])
            ->andFilterWhere(['=', 'unit_gudang.kode_unit','G001'])
            ->andWhere('stok <= barang.stock_warning')
            ->andFilterWhere(['like', 'barang.deskripsi', $this->deskripsi])
            ->andFilterWhere(['like', 'barang.nama_barang', $this->nama_barang]);

        // $posts = $dataProvider->getModels();

        // print_r($query->all());
        // exit;

        return $dataProvider;
    }

    
}
