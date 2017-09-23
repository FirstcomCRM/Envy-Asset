<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Commission;

/**
 * CommissionSearch represents the model behind the search form about `common\models\Commission`.
 */
class CommissionSearch extends Commission
{
    /**
     * @inheritdoc
     */
    public $start;
    public $end;

    public function rules()
    {
        return [
            [['id', 'transact_id', 'sales_person'], 'integer'],
            [['transact_type', 'transact_date', 'date_added','start','end'], 'safe'],
            [['transact_amount', 'commision_percent', 'commission'], 'number'],
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
        $query = Commission::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if (!empty($this->transact_date) ) {
          list($this->start,$this->end) = explode(' - ', $this->transact_date);
        }else{
          $this->start = '';
          $this->end = '';
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'transact_id' => $this->transact_id,
            'transact_amount' => $this->transact_amount,
            'sales_person' => $this->sales_person,
            'commision_percent' => $this->commision_percent,
            'commission' => $this->commission,
            'date_added' => $this->date_added,
        ]);

        $query->andFilterWhere(['like', 'transact_type', $this->transact_type])
              ->andFilterWhere(['between','transact_date',$this->start,$this->end]);

        return $dataProvider;
    }
}
