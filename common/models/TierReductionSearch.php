<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TierReduction;

/**
 * TierReductionSearch represents the model behind the search form about `common\models\TierReduction`.
 */
class TierReductionSearch extends TierReduction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['highest_percent', 'reduction_percent', 'lowest_percent'], 'number'],
            [['date_added'], 'safe'],
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
        $query = TierReduction::find();

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
            'highest_percent' => $this->highest_percent,
            'reduction_percent' => $this->reduction_percent,
            'lowest_percent' => $this->lowest_percent,
            'date_added' => $this->date_added,
        ]);

        return $dataProvider;
    }
}
