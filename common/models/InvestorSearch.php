<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `common\models\Customer`.
 */
class InvestorSearch extends Investor
{
    /**
     * @inheritdoc
     */
    public $date_filter;
    public function rules()
    {
        return [
            [['id', 'mobile'], 'integer'],
            [['company_name', 'date_filter','customer_group', 'contact_person', 'email', 'address', 'remark','company_registration','nric','passport_no',], 'safe'],
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
        $query = Investor::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
              'pageSize'=>10,
            ],
            'sort'=>[
              'defaultOrder'=>[
                  'id'=>SORT_DESC,
              ],
            ],

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
            'mobile' => $this->mobile,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_registration', $this->company_registration])
            ->andFilterWhere(['like', 'passport_no', $this->passport_no])
            ->andFilterWhere(['like', 'nric', $this->nric]);

        return $dataProvider;
    }

    public function alterSearch($params){
      $query = Investor::find();

      // add conditions that should always apply here

      $dataProvider = new ActiveDataProvider([
          'query' => $query,
          'pagination'=>[
            'pageSize'=>10,
          ],
          'sort'=>[
            'defaultOrder'=>[
                'id'=>SORT_DESC,
            ],
          ],

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
          'mobile' => $this->mobile,
      ]);

      $query->andFilterWhere(['like', 'company_name', $this->company_name])
          ->andFilterWhere(['like', 'company_registration', $this->company_registration])
          ->andFilterWhere(['like', 'passport_no', $this->passport_no])
          ->andFilterWhere(['like', 'nric', $this->nric]);

      return $dataProvider;
    }
}
