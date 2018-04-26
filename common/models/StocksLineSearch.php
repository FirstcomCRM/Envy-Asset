<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StocksLine;

/**
 * StocksLineSearch represents the model behind the search form of `common\models\StocksLine`.
 */
class StocksLineSearch extends StocksLine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'stocks_id', 'month_curr'], 'integer'],
            [['month'], 'safe'],
            [['month_price', 'month_rate', 'unrealized_curr', 'unrealized_local'], 'number'],
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
        $query = StocksLine::find();

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
            'month' => $this->month,
            'month_curr' => $this->month_curr,
            'month_price' => $this->month_price,
            'month_rate' => $this->month_rate,
            'unrealized_curr' => $this->unrealized_curr,
            'unrealized_local' => $this->unrealized_local,
        ]);

        return $dataProvider;
    }
}
