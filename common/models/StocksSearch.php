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

     public $start;
     public $end;

    public function rules()
    {
        return [
            [['id', 'added_by', 'edited_by'], 'integer'],
            [['stock','date', 'add_in', 'buy_in_price', 'current_market', 'unrealized', 'date_created', 'date_edited', 'date_added','start','end'], 'safe'],
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

        if (!empty($this->date)) {
          list($this->start,$this->end)= explode(' - ',$this->date);
          $this->start = date('Y-m-d',strtotime($this->start) );
          $this->end = date('Y-m-d',strtotime($this->end) );
        }

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
            'date_added' => $this->date_added,
        ]);

        $query->andFilterWhere(['like', 'stock', $this->stock])
            ->andFilterWhere(['like', 'add_in', $this->add_in])
            ->andFilterWhere(['like', 'buy_in_price', $this->buy_in_price])
            ->andFilterWhere(['like', 'current_market', $this->current_market])
            ->andFilterWhere(['like', 'unrealized', $this->unrealized])
            ->andFilterWhere(['between', 'date', $this->start,$this->end]);

        return $dataProvider;
    }
}
