<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PurchaseEarning;
use yii\db\Query;
/**
 * PurchaseEarningSearch represents the model behind the search form about `common\models\PurchaseEarning`.
 */
class PurchaseEarningSearch extends PurchaseEarning
{
    /**
     * @inheritdoc
     */
     public $investor;
    public function rules()
    {
        return [
            [['id', 'purchase_id'], 'integer'],
            [['purchase_date', 'expiry_date', 're_date','investor'], 'safe'],
            [['re_metal_per', 'customer_earn', 'customer_earn_after', 'company_earn', 'staff_earn'], 'number'],
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
      //  $query = PurchaseEarning::find();
        $query = new Query();
        $query->select(['pe.re_date','pe.id as ids','pe.purchase_id','pe.re_metal_per','pe.customer_earn','pe.customer_earn_after',
              'pe.company_earn','pe.tranche','pe.purchase_amount','inv.company_name','pur.investor',
            ])
          ->from('purchase_earning as pe')
          ->JOIN('LEFT JOIN', 'purchase pur', 'pur.id=pe.purchase_id')
          ->JOIN('LEFT JOIN', 'investor inv', 'inv.id=pur.investor');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
          'attributes'=>[
            'ids',
            'purchase_id',
            'customer_earn',
        //    'price',
            'purchase_amount',
            're_date',
            're_metal_per',
            'price',
            'company_earn',
            'tranche',
          ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
      /*  $query->andFilterWhere([
            'pe.id' => $this->id,
            'purchase_id' => $this->purchase_id,
            'purchase_date' => $this->purchase_date,
            'expiry_date' => $this->expiry_date,
            're_date' => $this->re_date,
            're_metal_per' => $this->re_metal_per,
            'purchase_amount' => $this->purchase_amount,
            'customer_earn' => $this->customer_earn,
            'customer_earn_after' => $this->customer_earn_after,
            'company_earn' => $this->company_earn,
            'staff_earn' => $this->staff_earn,
        ]);*/
        $query->andFilterWhere([
            'inv.company_name' => $this->investor,
            'pe.id'=>$this->id,

        ]);

        return $dataProvider;
    }
}
