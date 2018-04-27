<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StocksLinea;

/**
 * StocksLineaSearch represents the model behind the search form of `common\models\StocksLinea`.
 */
class StocksLineaSearch extends StocksLinea
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stocks_id', 'sold_currency', 'sold_units'], 'integer'],
            [['sold_date'], 'safe'],
            [['currency_rate', 'sold_price', 'balance'], 'number'],
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
        $query = StocksLinea::find();

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
            'stocks_id' => $this->stocks_id,
            'sold_date' => $this->sold_date,
            'sold_currency' => $this->sold_currency,
            'currency_rate' => $this->currency_rate,
            'sold_price' => $this->sold_price,
            'sold_units' => $this->sold_units,
            'balance' => $this->balance,
        ]);

        return $dataProvider;
    }
}
