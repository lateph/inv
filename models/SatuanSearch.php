<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Satuan;

/**
 * SatuanSearch represents the model behind the search form about `app\models\Satuan`.
 */
class SatuanSearch extends Satuan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_satuan', 'satuan_barang', 'singkatan'], 'safe'],
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
        $query = Satuan::find();

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
        $query->andFilterWhere(['like', 'kode_satuan', $this->kode_satuan])
            ->andFilterWhere(['like', 'satuan_barang', $this->satuan_barang])
            ->andFilterWhere(['like', 'singkatan', $this->singkatan]);

        return $dataProvider;
    }
}
