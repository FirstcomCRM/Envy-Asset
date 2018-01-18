<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MetalOil;

/**
 * MetalOilSearch represents the model behind the search form about `common\models\MetalOil`.
 */
class MetalOilSearch extends MetalOil
{
    /**
     * @inheritdoc
     */
    public $start;
    public $end;

    public function rules()
    {
        return [
            [['id', 'import_metal_id', 'date'], 'integer'],
            [['date_uploaded', 'oil_price', 'oil_open', 'oil_high', 'oil_low', 'oil_change','date_filter','end','start'], 'safe'],
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
        $query = MetalOil::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
              'pageSize'=>30,
            ]
        ]);

        $this->load($params);

        if (!empty($this->date_filter)) {
          list($this->start,$this->end)= explode(' - ',$this->date_filter);
        }

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
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'oil_price', $this->oil_price])
            ->andFilterWhere(['like', 'oil_open', $this->oil_open])
            ->andFilterWhere(['like', 'oil_high', $this->oil_high])
            ->andFilterWhere(['like', 'oil_low', $this->oil_low])
            ->andFilterWhere(['like', 'oil_change', $this->oil_change])
            ->andFilterWhere(['between', 'date_filter', $this->start,$this->end]);

        return $dataProvider;
    }
}
