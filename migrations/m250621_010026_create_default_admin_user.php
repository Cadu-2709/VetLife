<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%default_admin_user}}`.
 * O nome da classe DEVE ser o mesmo nome do ficheiro.
 * Ex: Se o ficheiro é m250621_010026_create_default_admin_user.php,
 * a classe deve ser class m250621_010026_create_default_admin_user extends Migration
 */
class m250621_010026_create_default_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Gera um hash seguro para a palavra-passe 'admin'
        $passwordHash = Yii::$app->security->generatePasswordHash('admin');

        // Insere o utilizador administrador na tabela
        $this->insert('vetlife.user', [
            'email' => 'admin@vetlife.com',
            'pwd_hash' => $passwordHash,
            'role' => 'admin',
            'created_at' => new \yii\db\Expression('NOW()'),
            'updated_at' => new \yii\db\Expression('NOW()'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Remove o utilizador administrador ao reverter a migration
        $this->delete('vetlife.user', ['email' => 'admin@vetlife.com']);
    }
}