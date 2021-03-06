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
    public $dummy_id;

    public function rules()
    {
        return [
            [['id','salesperson','dummy_id'], 'integer'],
            [['investor', 'product', 'share', 'purchase_type','date','start','end', 'remarks', 'purchase_no'], 'safe'],
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
            'purchase_type'=>$this->purchase_type,
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
        //list($this->start,$this->end) = explode(' - ', $this->date);
         $mdate = new \DateTime($this->date);
         $this->start = $mdate->format('Y-m-01');
         $this->end = $mdate->format('Y-m-t');
      //  print_r($this->start);die();
      }else{

        $this->start = '';
        $this->end = '';
      }

      if (!$this->validate()) {
          // uncomment the following line if you do not want to return any records when validation fails
          // $query->where('0=1');
          return $dataProvider;
      }

    //  if (!empty($this->id) || !empty($this->salesperson) || !empty($this->date) ) {
    //    $query->andFilterwhere(['<=','date',$this->start])
        $query->andFilterwhere(['between','date',$this->start,$this->end])
              //->andFilterwhere(['>=','expiry_date',$this->end])
              ->andFilterWhere(['salesperson'=>$this->salesperson])
              ->andFilterwhere(['id'=>$this->id])
              ->andFilterwhere(['id'=>$this->dummy_id])
              ->andFilterWhere(['purchase_no'=>$this->purchase_no]);

    //  }else{
      //  $query->andFilterwhere(['id'=>0]);
    //  }


      return $dataProvider;

    }
}
