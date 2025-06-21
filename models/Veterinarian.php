<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "vetlife.veterinarian".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $cpf
 * @property string $speciality
 * @property string $crmv
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property MedicalHistory[] $medicalHistories
 * @property Scheduling[] $schedulings
 */
class Veterinarian extends ActiveRecord
{
    public static function tableName()
    {
        return 'vetlife.veterinarian';
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
            [['name', 'email', 'cpf', 'speciality', 'crmv'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['email', 'speciality'], 'string', 'max' => 100],
            [['cpf'], 'string', 'max' => 11],
            [['crmv'], 'string', 'max' => 10],
            [['email'], 'unique'],
            [['cpf'], 'unique'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nome',
            'email' => 'E-mail',
            'cpf' => 'CPF',
            'speciality' => 'Especialidade',
            'crmv' => 'CRMV',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getMedicalHistories()
    {
        return $this->hasMany(MedicalHistory::class, ['id_vet' => 'id']);
    }

    public function getSchedulings()
    {
        return $this->hasMany(Scheduling::class, ['id_vet' => 'id']);
    }
    /**
     * Método auxiliar para obter uma lista de veterinários para dropdowns.
     * @return array
     */
    public static function getVeterinarianList()
    {
        $vets = Veterinarian::find()->orderBy('name')->asArray()->all();
        return \yii\helpers\ArrayHelper::map($vets, 'id', 'name');
    }
}