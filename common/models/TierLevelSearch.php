<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TierLevel;

/**
 * TierLevelSearch represents the model behind the search form about `common\models\TierLevel`.
 */
class TierLevelSearch extends TierLevel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'connecting_level'], 'integer'],
            [['tier_level', 'date_added'], 'safe'],
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
        $query = TierLevel::find();

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
            'connecting_level' => $this->connecting_level,
            'date_added' => $this->date_added,
        ]);

        $query->andFilterWhere(['like', 'tier_level', $this->tier_level]);

        return $dataProvider;
    }
}
