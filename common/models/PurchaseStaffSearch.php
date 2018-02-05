<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PurchaseStaff;

/**
 * PurchaseStaffSearch represents the model behind the search form about `common\models\PurchaseStaff`.
 */
class PurchaseStaffSearch extends PurchaseStaff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'salesperson'], 'integer'],
            [['purchase_no', 'staff', 'product', 'share', 'date', 'remarks', 'date_added'], 'safe'],
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
        $query = PurchaseStaff::find();

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
            'salesperson' => $this->salesperson,
            'date_added' => $this->date_added,
        ]);

        $query->andFilterWhere(['like', 'purchase_no', $this->purchase_no])
            ->andFilterWhere(['like', 'staff', $this->staff])
            ->andFilterWhere(['like', 'product', $this->product])
            ->andFilterWhere(['like', 'share', $this->share])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
