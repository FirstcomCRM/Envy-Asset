<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MetalUnrealised;

/**
 * MetalUnrealisedSearch represents the model behind the search form about `common\models\MetalUnrealised`.
 */
class MetalUnrealisedSearch extends MetalUnrealised
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'import_metal_id'], 'integer'],
            [['date_uploaded', 'commodity', 'position', 'entry_date_usd', 'exit_date_usd', 'realised_gain_percent'], 'safe'],
            [['entry_price_usd', 'entry_value_usd', 'exit_price_usd', 'exit_value_usd', 'realised_gain_usd', 'profit_lost_usd', 'profit_lost_sgd'], 'number'],
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
        $query = MetalUnrealised::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
              'pageSize'=>10,
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
            'import_metal_id' => $this->import_metal_id,
            'date_uploaded' => $this->date_uploaded,
            'entry_date_usd' => $this->entry_date_usd,
            'entry_price_usd' => $this->entry_price_usd,
            'entry_value_usd' => $this->entry_value_usd,
            'exit_date_usd' => $this->exit_date_usd,
            'exit_price_usd' => $this->exit_price_usd,
            'exit_value_usd' => $this->exit_value_usd,
            'realised_gain_usd' => $this->realised_gain_usd,
            'profit_lost_usd' => $this->profit_lost_usd,
            'profit_lost_sgd' => $this->profit_lost_sgd,
        ]);

        $query->andFilterWhere(['like', 'commodity', $this->commodity])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'realised_gain_percent', $this->realised_gain_percent]);

        return $dataProvider;
    }
}
