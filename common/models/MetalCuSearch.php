<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MetalCu;

/**
 * MetalCuSearch represents the model behind the search form about `common\models\MetalCu`.
 */
class MetalCuSearch extends MetalCu
{
    /**
     * @inheritdoc
     */
     public $start;
    public $end;

    public function rules()
    {
        return [
            [['id', 'import_metal_id'], 'integer'],
            [['date_uploaded', 'date', 'cu_cash', 'cu_three_month', 'cu_stock','date_filter','end','start'], 'safe'],
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
        $query = MetalCu::find();

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
        ]);

        $query->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'cu_cash', $this->cu_cash])
            ->andFilterWhere(['like', 'cu_three_month', $this->cu_three_month])
            ->andFilterWhere(['like', 'cu_stock', $this->cu_stock])
            ->andFilterWhere(['between', 'date_filter', $this->start,$this->end]);

        return $dataProvider;
    }
}
