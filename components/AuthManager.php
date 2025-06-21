<?php

namespace app\components;

use Yii;
use yii\base\Component;
use yii\web\ForbiddenHttpException;

/**
 * Componente de gerenciamento de autorização personalizado
 * Controla acesso baseado em roles de usuário
 */
class AuthManager extends Component
{
    /**
     * Verifica se o usuário tem a role especificada
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        
        return Yii::$app->user->identity->role === $role;
    }

    /**
     * Verifica se o usuário tem uma das roles especificadas
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        
        return in_array(Yii::$app->user->identity->role, $roles);
    }

    /**
     * Verifica se o usuário tem todas as roles especificadas
     * @param array $roles
     * @return bool
     */
    public function hasAllRoles($roles)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }
        
        return in_array(Yii::$app->user->identity->role, $roles);
    }

    /**
     * Verifica se o usuário é administrador
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Verifica se o usuário é veterinário
     * @return bool
     */
    public function isVeterinarian()
    {
        return $this->hasRole('veterinarian');
    }

    /**
     * Verifica se o usuário é recepcionista
     * @return bool
     */
    public function isReceptionist()
    {
        return $this->hasRole('receptionist');
    }

    /**
     * Verifica se o usuário é cliente
     * @return bool
     */
    public function isClient()
    {
        return $this->hasRole('client');
    }

    /**
     * Lança exceção se o usuário não tiver a role especificada
     * @param string $role
     * @throws ForbiddenHttpException
     */
    public function requireRole($role)
    {
        if (!$this->hasRole($role)) {
            throw new ForbiddenHttpException('Acesso negado. Role necessária: ' . $role);
        }
    }

    /**
     * Lança exceção se o usuário não tiver uma das roles especificadas
     * @param array $roles
     * @throws ForbiddenHttpException
     */
    public function requireAnyRole($roles)
    {
        if (!$this->hasAnyRole($roles)) {
            throw new ForbiddenHttpException('Acesso negado. Uma das roles necessárias: ' . implode(', ', $roles));
        }
    }

    /**
     * Retorna as roles disponíveis no sistema
     * @return array
     */
    public function getAvailableRoles()
    {
        return [
            'admin' => 'Administrador',
            'veterinarian' => 'Veterinário',
            'receptionist' => 'Recepcionista',
            'client' => 'Cliente',
        ];
    }

    /**
     * Retorna as permissões por role
     * @return array
     */
    public function getRolePermissions()
    {
        return [
            'admin' => [
                'user.*',
                'client.*',
                'veterinarian.*',
                'animal.*',
                'service.*',
                'scheduling.*',
                'scheduling-status.*',
                'medical-history.*',
            ],
            'veterinarian' => [
                'animal.view',
                'animal.index',
                'scheduling.view',
                'scheduling.index',
                'scheduling.update',
                'scheduling-status.view',
                'scheduling-status.index',
                'medical-history.*',
            ],
            'receptionist' => [
                'client.*',
                'animal.*',
                'scheduling.*',
                'scheduling-status.*',
                'service.view',
                'service.index',
                'veterinarian.view',
                'veterinarian.index',
            ],
            'client' => [
                'animal.view',
                'animal.index',
                'scheduling.view',
                'scheduling.index',
                'scheduling.create',
                'scheduling.update',
                'medical-history.view',
                'medical-history.index',
            ],
        ];
    }

    /**
     * Verifica se o usuário tem permissão para uma ação específica
     * @param string $permission (formato: controller.action)
     * @return bool
     */
    public function can($permission)
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $userRole = Yii::$app->user->identity->role;
        $rolePermissions = $this->getRolePermissions();

        if (!isset($rolePermissions[$userRole])) {
            return false;
        }

        $permissions = $rolePermissions[$userRole];

        // Verifica permissão exata
        if (in_array($permission, $permissions)) {
            return true;
        }

        // Verifica permissão wildcard (ex: user.*)
        foreach ($permissions as $perm) {
            if (strpos($perm, '.*') !== false) {
                $controller = str_replace('.*', '', $perm);
                if (strpos($permission, $controller . '.') === 0) {
                    return true;
                }
            }
        }

        return false;
    }
}