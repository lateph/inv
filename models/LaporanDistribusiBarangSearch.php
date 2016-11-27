<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DistribusiBarang;

/**
 * LaporanDistribusiBarangSearch represents the model behind the search form about `app\models\DistribusiBarang`.
 */
class LaporanDistribusiBarangSearch extends DistribusiBarang
{
    public $kode_barang;
    public $tgl1;
    public $tgl2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_distribusi', 'kode_unit', 'kode_barang', 'no_po', 'pengirim', 'keterangan','kode_barang','tgl1','tgl2'], 'safe'],
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
        $query = DistribusiBarang::find();

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

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'tanggal_distribusi' => $this->tanggal_distribusi,
        // ]);

        $query->joinWith(['details','unit']);

        // $query->joinWith(['details' => function ($q) {
        //     $q->onCondition(['distribusi_barang_detail.kode_barang'=>$this->kode_barang]);
        // }]);

        $query->andFilterWhere(['like', 'no_distribusi', $this->no_distribusi])
            ->andFilterWhere(['like', 'distribusi_barang.kode_unit', $this->kode_unit])
            ->andFilterWhere(['like', 'kode_project', $this->kode_project])
            ->andFilterWhere(['=', 'distribusi_barang_detail.kode_barang', $this->kode_barang])
            ->andFilterWhere(['>=', 'tanggal_distribusi', $this->tgl1]);

        if($this->tgl2)
            $query->andFilterWhere(['<=', 'tanggal_distribusi', $this->tgl2.' 23:59']);

        return $dataProvider;
    }
}
