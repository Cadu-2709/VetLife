<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "vetlife.client".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $cpf
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Animal[] $animals
 */
class Client extends ActiveRecord
{
    public static function tableName()
    {
        return 'vetlife.client';
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
            [['name', 'email', 'phone', 'cpf'], 'required'],
            
            // ADICIONADO: Remove caracteres não numéricos do CPF antes da validação
            ['cpf', 'filter', 'filter' => function ($value) {
                return preg_replace('/[^0-9]/', '', $value);
            }],

            [['name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['cpf'], 'string', 'max' => 11], // Esta regra agora funcionará corretamente
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
            'phone' => 'Telefone',
            'cpf' => 'CPF',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnimals()
    {
        return $this->hasMany(Animal::class, ['id_client' => 'id']);
    }
}