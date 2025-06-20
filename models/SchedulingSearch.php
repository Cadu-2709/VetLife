<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Scheduling;

/**
 * SchedulingSearch representa o modelo por trás do formulário de pesquisa de `app\models\Scheduling`.
 */
class SchedulingSearch extends Scheduling
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_animal', 'id_vet', 'id_service', 'id_status'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // ignora a implementação de scenarios() na classe pai
        return Model::scenarios();
    }

    /**
     * Cria uma instância de data provider com a consulta de pesquisa aplicada
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Scheduling::find();

        // adiciona condições que devem sempre ser aplicadas aqui

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // descomente a linha seguinte se não quiser retornar nenhum registo quando a validação falhar
            // $query->where('0=1');
            return $dataProvider;
        }

        // condições de filtragem da grelha
        $query->andFilterWhere([
            'id' => $this->id,
            'id_animal' => $this->id_animal,
            'id_vet' => $this->id_vet,
            'id_service' => $this->id_service,
            'id_status' => $this->id_status,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
