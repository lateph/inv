<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Adjustment;

/**
 * AdjustmentSearch represents the model behind the search form about `app\models\Adjustment`.
 */
class AdjustmentSearch extends Adjustment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no_adjustment', 'tanggal_adjustment', 'kode_barang', 'kondisi', 'keterangan', 'kode_unit', 'penanggung_jawab'], 'safe'],
            [['qty'], 'integer'],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'tanggal_adjustment' => $this->tanggal_adjustment,
            'qty' => $this->qty,
        ]);

        $query->andFilterWhere(['like', 'no_adjustment', $this->no_adjustment])
            ->andFilterWhere(['like', 'kode_barang', $this->kode_barang])
            ->andFilterWhere(['like', 'kondisi', $this->kondisi])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'kode_unit', $this->kode_unit])
            ->andFilterWhere(['like', 'penanggung_jawab', $this->penanggung_jawab]);

        return $dataProvider;
    }
}
