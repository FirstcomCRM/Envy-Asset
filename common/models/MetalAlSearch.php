<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MetalAl;

/**
 * MetalAlSearch represents the model behind the search form about `common\models\MetalAl`.
 */
class MetalAlSearch extends MetalAl
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
            [['date_uploaded', 'date','date_filter','start','end'], 'safe'],
            [['al_cash', 'al_three_month', 'al_stocl'], 'number'],
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
        $query = MetalAl::find();

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
            'al_cash' => $this->al_cash,
            'al_three_month' => $this->al_three_month,
            'al_stocl' => $this->al_stocl,
        ]);

        $query->andFilterWhere(['like', 'date', $this->date])
              ->andFilterWhere(['between', 'date_filter', $this->start, $this->end]);

        return $dataProvider;
    }
}
