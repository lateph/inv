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
class LaporanStokBarangSearch extends Barang
{
    public $tampil_stok_kosong;
    public $stok;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_barang', 'kode_kategori', 'kode_satuan', 'deskripsi','tampil_stok_kosong'], 'safe'],
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
        $query = LaporanStokBarangSearch::find()->select('barang.*, sum(qty_in - qty_out) as stok');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith(['satuan','kategori','inout']);
        $query->groupBy(['barang.kode_barang', 'inout.idgudang']);

        $query->andFilterWhere(['=', 'barang.kode_barang', $this->kode_barang])
            ->andFilterWhere(['=', 'barang.kode_kategori', $this->kode_kategori])
            ->andFilterWhere(['=', 'barang.kode_satuan', $this->kode_satuan])
            ->andFilterWhere(['=', 'inout.idgudang','G001'])
            ->andFilterWhere(['like', 'barang.deskripsi', $this->deskripsi]);


        return $dataProvider;
    }

    
}
