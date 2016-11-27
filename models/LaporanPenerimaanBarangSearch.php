<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenerimaanBarang;

/**
 * LaporanPenerimaanBarangSearch represents the model behind the search form about `app\models\PenerimaanBarang`.
 */
class LaporanPenerimaanBarangSearch extends PenerimaanBarang
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
            [['no_penerimaan', 'tanggal_penerimaan', 'supplier', 'no_po', 'pengirim', 'keterangan','kode_barang','tgl1','tgl2'], 'safe'],
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
        $query = PenerimaanBarang::find();

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
        //     'tanggal_penerimaan' => $this->tanggal_penerimaan,
        // ]);

        $query->joinWith(['details']);

        // $query->joinWith(['details' => function ($q) {
        //     $q->onCondition(['penerimaan_barang_detail.kode_barang'=>$this->kode_barang]);
        // }]);

        $query->andFilterWhere(['like', 'no_penerimaan', $this->no_penerimaan])
            ->andFilterWhere(['like', 'supplier', $this->supplier])
            ->andFilterWhere(['like', 'no_po', $this->no_po])
            ->andFilterWhere(['like', 'pengirim', $this->pengirim])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['=', 'penerimaan_barang_detail.kode_barang', $this->kode_barang])
            ->andFilterWhere(['>=', 'tanggal_penerimaan', $this->tgl1]);

        if($this->tgl2)
            $query->andFilterWhere(['<=', 'tanggal_penerimaan', $this->tgl2.' 23:59']);

        return $dataProvider;
    }
}
