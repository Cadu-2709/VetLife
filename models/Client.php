<?php

namespace app\models;

use Yii;

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
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vetlife.client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'cpf'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['cpf'], 'string', 'max' => 11],
            [['email'], 'unique'],
            [['cpf'], 'unique'],
            [['email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
     * Gets query for [[Animals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnimals()
    {
        return $this->hasMany(Animal::class, ['id_client' => 'id']);
    }
}