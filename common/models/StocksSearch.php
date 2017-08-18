<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Stocks;

/**
 * StocksSearch represents the model behind the search form about `common\models\Stocks`.
 */
class StocksSearch extends Stocks
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'added_by', 'edited_by'], 'integer'],
            [['stock', 'date_created', 'date_edited'], 'safe'],
            [['price'], 'number'],
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
        $query = Stocks::find();

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
            'id' => $this->id,
            'price' => $this->price,
            'date_created' => $this->date_created,
            'date_edited' => $this->date_edited,
            'added_by' => $this->added_by,
            'edited_by' => $this->edited_by,
        ]);

        $query->andFilterWhere(['like', 'stock', $this->stock]);

        return $dataProvider;
    }
}
