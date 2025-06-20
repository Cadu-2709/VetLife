<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "vetlife.scheduling".
 *
 * @property int $id
 * @property int $id_animal
 * @property int $id_vet
 * @property int $id_service
 * @property int $id_status
 * @property string $date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Animal $animal
 * @property Service $service
 * @property SchedulingStatus $status
 * @property Veterinarian $vet
 */
class Scheduling extends ActiveRecord
{
    public static function tableName()
    {
        return 'vetlife.scheduling';
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
            [['id_animal', 'id_vet', 'id_service', 'id_status', 'date'], 'required'],
            [['id_animal', 'id_vet', 'id_service', 'id_status'], 'integer'],
            [['date'], 'safe'],
            [['id_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Animal::class, 'targetAttribute' => ['id_animal' => 'id']],
            [['id_service'], 'exist', 'skipOnError' => true, 'targetClass' => Service::class, 'targetAttribute' => ['id_service' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => SchedulingStatus::class, 'targetAttribute' => ['id_status' => 'id']],
            [['id_vet'], 'exist', 'skipOnError' => true, 'targetClass' => Veterinarian::class, 'targetAttribute' => ['id_vet' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_animal' => 'Animal',
            'id_vet' => 'Veterinário',
            'id_service' => 'Serviço',
            'id_status' => 'Status',
            'date' => 'Data do Agendamento',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getAnimal()
    {
        return $this->hasOne(Animal::class, ['id' => 'id_animal']);
    }

    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'id_service']);
    }

    public function getStatus()
    {
        return $this->hasOne(SchedulingStatus::class, ['id' => 'id_status']);
    }

    public function getVet()
    {
        return $this->hasOne(Veterinarian::class, ['id' => 'id_vet']);
    }
}