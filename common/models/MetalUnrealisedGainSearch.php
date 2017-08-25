<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MetalUnrealisedGain;

/**
 * MetalUnrealisedGainSearch represents the model behind the search form about `common\models\MetalUnrealisedGain`.
 */
class MetalUnrealisedGainSearch extends MetalUnrealisedGain
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'import_metal_id'], 'integer'],
            [['usd', 'sgd', 'gain_loss'], 'number'],
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
        $query = MetalUnrealisedGain::find();

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
            'usd' => $this->usd,
            'sgd' => $this->sgd,
            'gain_loss' => $this->gain_loss,
        ]);

        return $dataProvider;
    }
}
