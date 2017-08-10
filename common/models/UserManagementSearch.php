<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserManagement;

/**
 * UserManagementSearch represents the model behind the search form about `common\models\UserManagement`.
 */
class UserManagementSearch extends UserManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'mobile'], 'integer'],
            [['name', 'user_group', 'department', 'email', 'nationality', 'address', 'remark', 'login_id', 'login_password'], 'safe'],
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
        $query = UserManagement::find();

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
            'user_id' => $this->user_id,
            'mobile' => $this->mobile,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'user_group', $this->user_group])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nationality', $this->nationality])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'login_id', $this->login_id])
            ->andFilterWhere(['like', 'login_password', $this->login_password]);

        return $dataProvider;
    }
}
