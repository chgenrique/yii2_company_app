<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StaffMember;

/**
 * StaffMemberSearch represents the model behind the search form of `app\models\StaffMember`.
 */
class StaffMemberSearch extends StaffMember
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'departament_id'], 'integer'],
            [['member_name', 'date_hire'], 'safe'],
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
        $query = StaffMember::find();

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
            'departament_id' => $this->departament_id,
            'date_hire' => $this->date_hire,
        ]);

        $query->andFilterWhere(['like', 'member_name', $this->member_name]);

        return $dataProvider;
    }
}
