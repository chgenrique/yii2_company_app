<?php

namespace app\models\member;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * SearchStaffMember represents the model behind the search form of `app\models\StaffMember`.
 */
class SearchStaffMember extends StaffMember
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'department_id'], 'integer'],
            [['member_name', 'date_hire','department_id'], 'safe'],
            [['date_hire'], 'date', 'format' => 'php:Y-m-d'],
            // an inline validator defined as an anonymous function
//            ['date_hire', function ($attribute, $params, $validator) {
//                if (!ctype_alnum($this->$attribute)) {
//                    $this->addError($attribute, 'The token must contain letters or digits.');
//                }
//            }],
   
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
        $query->joinWith(['department']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $this->load($params);

        
        // Here is the problem
        /*if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/
        

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'date_hire' => $this->date_hire
        ]);
        $query->andFilterWhere(['like','department.name',$this->department_id]);
        $query->andFilterWhere(['like', 'member_name', $this->member_name]);

        return $dataProvider;
    }
}
