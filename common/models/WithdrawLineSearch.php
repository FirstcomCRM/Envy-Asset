<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WithdrawLine;

/**
 * WithdrawLineSearch represents the model behind the search form about `common\models\WithdrawLine`.
 */
class WithdrawLineSearch extends WithdrawLine
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'header_id'], 'integer'],
            [['withdraw'], 'number'],
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
        $query = WithdrawLine::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'header_id' => $this->header_id,
            'withdraw' => $this->withdraw,
            'date_added' => $this->date_added,
        ]);

        return $dataProvider;
    }
}
