<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PurchaseLine;

/**
 * PurchaseLineSearch represents the model behind the search form of `common\models\PurchaseLine`.
 */
class PurchaseLineSearch extends PurchaseLine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'purchase_id'], 'integer'],
            [['psold_date'], 'safe'],
            [['psold_currency', 'pcurrency_rate', 'psold_price', 'psold_units', 'pbalance'], 'number'],
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
        $query = PurchaseLine::find();

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
            'purchase_id' => $this->purchase_id,
            'psold_date' => $this->psold_date,
            'psold_currency' => $this->psold_currency,
            'pcurrency_rate' => $this->pcurrency_rate,
            'psold_price' => $this->psold_price,
            'psold_units' => $this->psold_units,
            'pbalance' => $this->pbalance,
        ]);

        return $dataProvider;
    }
}
