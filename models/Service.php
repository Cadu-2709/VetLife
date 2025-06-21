<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "vetlife.service".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property int $duration_minutes
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Scheduling[] $schedulings
 */
class Service extends ActiveRecord
{
    public static function tableName()
    {
        return 'vetlife.service';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'price', 'duration_minutes'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['duration_minutes'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome do Serviço',
            'description' => 'Descrição',
            'price' => 'Preço',
            'duration_minutes' => 'Duração (minutos)',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getSchedulings()
    {
        // CORREÇÃO: Faltava o '=>' na definição da relação.
        return $this->hasMany(Scheduling::class, ['id_service' => 'id']);
    }
       // ... (dentro da classe Service)

    /**
     * Método auxiliar para obter uma lista de serviços para dropdowns.
     * @return array
     */
    public static function getServiceList()
    {
        $services = Service::find()->orderBy('name')->asArray()->all();
        return \yii\helpers\ArrayHelper::map($services, 'id', 'name');
    }
}