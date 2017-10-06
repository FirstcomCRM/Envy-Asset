<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Purchase;

/**
 * PurchaseSearch represents the model behind the search form about `common\models\Purchase`.
 */
class PurchaseSearch extends Purchase
{
    /**
     * @inheritdoc
     */
    public $start;
    public $end;

    public function rules()
    {
        return [
            [['id','salesperson'], 'integer'],
            [['investor', 'product', 'share', 'date','start','end', 'remarks'], 'safe'],
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
        $query = Purchase::find();

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
            'date' => $this->date,
            'salesperson'=>$this->salesperson,
        ]);

        $query->andFilterWhere(['like', 'investor', $this->investor])
            ->andFilterWhere(['like', 'product', $this->product])
            ->andFilterWhere(['like', 'share', $this->share])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }

    public function report_search($params){
      $query = Purchase::find();

      // add conditions that should always apply here

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination'=>[
            'pageSize'=>20,
            //'class'=>'testdata',
          ],
      ]);

      $this->load($params);

      if (!empty($this->date) ) {
        list($this->start,$this->end) = explode(' - ', $this->date);
      }else{
        $this->start = '';
        $this->end = '';
      }

      if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }

      if (!empty($this->id) || !empty($this->salesperson) || !empty($this->date) ) {
        $query->andFilterwhere(['between','date',$this->start,$this->end])
              ->andFilterWhere(['salesperson'=>$this->salesperson])
              ->andFilterwhere(['id'=>$this->id]);
      }else{
        $query->andFilterwhere(['id'=>0]);
      }


      return $dataProvider;

    }
}
