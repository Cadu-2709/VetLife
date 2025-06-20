<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior; // <-- IMPORTANTE: Importar o Behavior
use yii\db\Expression; // <-- IMPORTANTE: Importar a Expression

/**
 * This is the model class for table "vetlife.animal".
 *
 * @property int $id
 * @property int $id_client
 * @property string $name
 * @property string $species
 * @property string $race
 * @property string $sex
 * @property string|null $color
 * @property float $weight
 * @property string|null $obs
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Client $client
 * @property MedicalHistory[] $medicalHistories
 * @property Scheduling[] $schedulings
 */
class Animal extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vetlife.animal';
    }

    /**
     * Adiciona o comportamento para preenchimento automático de data/hora.
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // Usa a função NOW() do próprio banco de dados
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // As regras de 'created_at' e 'updated_at' foram removidas
        // porque agora são preenchidas automaticamente.
        return [
            [['id_client', 'name', 'species', 'race', 'sex', 'weight'], 'required'],
            [['id_client'], 'integer'],
            [['weight'], 'number'],
            [['obs'], 'string'],
            [['name', 'species', 'race'], 'string', 'max' => 255],
            [['sex', 'color'], 'string', 'max' => 100],
            [['id_client'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['id_client' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_client' => 'Tutor do Animal',
            'name' => 'Nome do Animal',
            'species' => 'Espécie',
            'race' => 'Raça',
            'sex' => 'Sexo',
            'color' => 'Cor',
            'weight' => 'Peso (kg)',
            'obs' => 'Observações',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    // ... (Os outros métodos getClient(), getMedicalHistories(), etc. continuam iguais)

    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'id_client']);
    }

    public function getMedicalHistories()
    {
        return $this->hasMany(MedicalHistory::class, ['id_animal' => 'id']);
    }

    public function getSchedulings()
    {
        return $this->hasMany(Scheduling::class, ['id_animal' => 'id']);
    }

    public static function getClientList()
    {
        $clients = Client::find()->orderBy('name')->asArray()->all();
        return ArrayHelper::map($clients, 'id', 'name');
    }
}