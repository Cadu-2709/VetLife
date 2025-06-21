<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "vetlife.user".
 *
 * @property int $id
 * @property string $email
 * @property string $pwd_hash
 * @property string $role
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    // Propriedade virtual para receber a password do formulário
    public $password;

    public static function tableName()
    {
        return 'vetlife.user';
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
            [['email', 'role'], 'required'],
            // A regra para 'pwd_hash' é removida daqui porque será gerada
            [['pwd_hash'], 'string', 'max' => 255], 
            // A regra para a password virtual é adicionada
            [['password'], 'required', 'on' => 'create'], // A password é obrigatória apenas na criação
            [['password'], 'string', 'min' => 6], // Exemplo de regra de password
            [['email'], 'string', 'max' => 100],
            [['role'], 'string', 'max' => 50],
            [['email'], 'unique'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'password' => 'Palavra-passe', // Label para a password virtual
            'pwd_hash' => 'Hash da Palavra-passe',
            'role' => 'Função',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    // Métodos da IdentityInterface para Autenticação
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // Não usaremos token de acesso neste projeto
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null; // Não usaremos "auth key" neste projeto
    }

    public function validateAuthKey($authKey)
    {
        return false; // Não usaremos "auth key" neste projeto
    }

    // Métodos para gestão da senha
    public function setPassword($password)
    {
        $this->pwd_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->pwd_hash);
    }
}