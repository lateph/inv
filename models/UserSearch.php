<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\user;

/**
 * UserSearch represents the model behind the search form about `app\models\user`.
 */
class UserSearch extends user
{
    public $unit;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_user', 'username', 'password', 'nama', 'kode_unit', 'hak_akses','unit'], 'safe'],
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
        $query = user::find();
        $query->joinWith(['unit']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);


        $dataProvider->sort->attributes['unit'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['unit.unit_kerja' => SORT_ASC],
            'desc' => ['unit.unit_kerja' => SORT_DESC],
        ];



        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        // grid filtering conditions
        $query->andFilterWhere(['like', 'kode_user', $this->kode_user])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['unit.kode_unit' => $this->unit])
            ->andFilterWhere(['like', 'hak_akses', $this->hak_akses]);

        return $dataProvider;
    }
}
