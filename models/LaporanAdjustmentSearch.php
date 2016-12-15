<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adjustment;

/**
 * LaporanAdjustmentSearch represents the model behind the search form about `app\models\Adjustment`.
 */
class LaporanAdjustmentSearch extends Adjustment
{
    public $tgl1;
    public $tgl2;
    public $kode_barang;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_adjustment', 'tanggal_adjustment', 'kode_barang', 'kondisi', 'keterangan', 'kode_unit', 'penanggung_jawab','tgl1','tgl2'], 'safe'],
            // [['qty'], 'integer'],
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
        $query = Adjustment::find();

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

        $query->joinWith(['details']);


        // $query->joinWith(['barang']);

        // grid filtering conditions
        $query->andFilterWhere([
            // 'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['like', 'no_adjustment', $this->no_adjustment])
            // ->andFilterWhere(['=', 'adjustment.kode_barang', $this->kode_barang])
            ->andFilterWhere(['=', 'adjustment.kondisi', $this->kondisi])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'kode_unit', $this->kode_unit])
            ->andFilterWhere(['like', 'penanggung_jawab', $this->penanggung_jawab])
            ->andFilterWhere(['=', 'adjustment_detail.kode_barang', $this->kode_barang])
            ->andFilterWhere(['>=', 'tanggal_adjustment', $this->tgl1]);

        if($this->tgl2)
            $query->andFilterWhere(['<=', 'tanggal_adjustment', $this->tgl2.' 23:59']);

        return $dataProvider;
    }
}
