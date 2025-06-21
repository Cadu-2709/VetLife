<?php

namespace app\helpers;

use Yii;

/**
 * Helper para funcionalidades de autorização nas views
 */
class AuthHelper
{
    /**
     * Verifica se o usuário tem permissão para uma ação específica
     * @param string $permission
     * @return bool
     */
    public static function can($permission)
    {
        return Yii::$app->authManager->can($permission);
    }

    /**
     * Verifica se o usuário tem uma das roles especificadas
     * @param array $roles
     * @return bool
     */
    public static function hasAnyRole($roles)
    {
        return Yii::$app->authManager->hasAnyRole($roles);
    }

    /**
     * Verifica se o usuário tem a role especificada
     * @param string $role
     * @return bool
     */
    public static function hasRole($role)
    {
        return Yii::$app->authManager->hasRole($role);
    }

    /**
     * Verifica se o usuário é administrador
     * @return bool
     */
    public static function isAdmin()
    {
        return Yii::$app->authManager->isAdmin();
    }

    /**
     * Verifica se o usuário é veterinário
     * @return bool
     */
    public static function isVeterinarian()
    {
        return Yii::$app->authManager->isVeterinarian();
    }

    /**
     * Verifica se o usuário é recepcionista
     * @return bool
     */
    public static function isReceptionist()
    {
        return Yii::$app->authManager->isReceptionist();
    }

    /**
     * Verifica se o usuário é cliente
     * @return bool
     */
    public static function isClient()
    {
        return Yii::$app->authManager->isClient();
    }

    /**
     * Retorna o nome da role atual do usuário
     * @return string|null
     */
    public static function getCurrentRole()
    {
        if (Yii::$app->user->isGuest) {
            return null;
        }
        return Yii::$app->user->identity->role;
    }

    /**
     * Retorna o nome amigável da role atual
     * @return string|null
     */
    public static function getCurrentRoleName()
    {
        $role = self::getCurrentRole();
        if ($role === null) {
            return null;
        }

        $roleNames = [
            'admin' => 'Administrador',
            'veterinarian' => 'Veterinário',
            'receptionist' => 'Recepcionista',
            'client' => 'Cliente',
        ];

        return $roleNames[$role] ?? $role;
    }

    /**
     * Retorna as roles disponíveis
     * @return array
     */
    public static function getAvailableRoles()
    {
        return Yii::$app->authManager->getAvailableRoles();
    }
}