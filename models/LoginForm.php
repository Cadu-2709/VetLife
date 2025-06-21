<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm é o modelo por trás do formulário de login.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array as regras de validação.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Palavra-passe',
            'rememberMe' => 'Lembrar-se de mim',
        ];
    }

    /**
     * Valida a palavra-passe.
     * Este método serve como a validação inline para a palavra-passe.
     *
     * @param string $attribute o atributo a ser validado
     * @param array $params os parâmetros adicionais dados à regra
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'E-mail ou palavra-passe incorretos.');
            }
        }
    }

    /**
     * Efetua o login de um utilizador usando o email e a palavra-passe fornecidos.
     * @return bool se o utilizador foi logado com sucesso
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Encontra o utilizador pelo [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findOne(['email' => $this->email]);
        }

        return $this->_user;
    }
}