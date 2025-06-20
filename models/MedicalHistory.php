<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "vetlife.medical_history".
 *
 * @property int $id
 * @property int $id_animal
 * @property int $id_vet
 * @property string|null $date
 * @property string|null $symptoms
 * @property string|null $diagnosis
 * @property string|null $treatment
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Animal $animal
 * @property Veterinarian $vet
 */
class MedicalHistory extends ActiveRecord
{
    public static function tableName()
    {
        return 'vetlife.medical_history';
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
            [['id_animal', 'id_vet'], 'required'],
            [['id_animal', 'id_vet'], 'integer'],
            [['date', 'symptoms', 'diagnosis', 'treatment'], 'string'],
            [['id_animal'], 'exist', 'skipOnError' => true, 'targetClass' => Animal::class, 'targetAttribute' => ['id_animal' => 'id']],
            [['id_vet'], 'exist', 'skipOnError' => true, 'targetClass' => Veterinarian::class, 'targetAttribute' => ['id_vet' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_animal' => 'Animal',
            'id_vet' => 'Veterinário',
            'date' => 'Data',
            'symptoms' => 'Sintomas',
            'diagnosis' => 'Diagnóstico',
            'treatment' => 'Tratamento',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getAnimal()
    {
        return $this->hasOne(Animal::class, ['id' => 'id_animal']);
    }

    public function getVet()
    {
        return $this->hasOne(Veterinarian::class, ['id' => 'id_vet']);
    }
}