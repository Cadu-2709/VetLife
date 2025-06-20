<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Animal;

/**
 * AnimalSearch represents the model behind the search form of `app\models\Animal`.
 */
class AnimalSearch extends Animal
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_client'], 'integer'],
            [['name', 'species', 'race', 'sex', 'color', 'obs', 'created_at', 'updated_at'], 'safe'],
            [['weight'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Animal::find();

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
            'id_client' => $this->id_client,
            'weight' => $this->weight,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'species', $this->species])
            ->andFilterWhere(['ilike', 'race', $this->race])
            ->andFilterWhere(['ilike', 'sex', $this->sex])
            ->andFilterWhere(['ilike', 'color', $this->color])
            ->andFilterWhere(['ilike', 'obs', $this->obs]);

        return $dataProvider;
    }
}