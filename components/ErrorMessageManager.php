<?php

namespace app\components;

use Yii;
use yii\base\Component;

/**
 * Componente para gerenciar mensagens de erro de autorização
 * Permite centralizar e personalizar mensagens de erro
 */
class ErrorMessageManager extends Component
{
    /**
     * @var array Mensagens de erro padrão por ação
     */
    private static $defaultMessages = [
        'index' => 'Você não tem permissão para visualizar a lista de {resource}.',
        'view' => 'Você não tem permissão para visualizar {resource}.',
        'create' => 'Você não tem permissão para criar {resource}.',
        'update' => 'Você não tem permissão para editar {resource}.',
        'delete' => 'Você não tem permissão para excluir {resource}.',
    ];

    /**
     * @var array Nomes dos recursos
     */
    private static $resourceNames = [
        'user' => 'usuários',
        'users' => 'usuários',
        'client' => 'clientes',
        'clients' => 'clientes',
        'animal' => 'animais',
        'animals' => 'animais',
        'scheduling' => 'agendamentos',
        'schedulings' => 'agendamentos',
        'service' => 'serviços',
        'services' => 'serviços',
        'veterinarian' => 'veterinários',
        'veterinarians' => 'veterinários',
        'medical-history' => 'histórico clínico',
        'medical-histories' => 'histórico clínico',
        'scheduling-status' => 'status de agendamento',
        'scheduling-statuses' => 'status de agendamento',
    ];

    /**
     * @var array Nomes das roles
     */
    private static $roleNames = [
        'admin' => 'Administrador',
        'veterinarian' => 'Veterinário',
        'receptionist' => 'Recepcionista',
        'client' => 'Cliente',
    ];

    /**
     * Gera mensagem de erro personalizada
     * @param string $action
     * @param string $controller
     * @param string $userRole
     * @param array $customMessages
     * @return string
     */
    public static function generateMessage($action, $controller, $userRole = null, $customMessages = [])
    {
        // Verifica se existe mensagem personalizada
        if (isset($customMessages[$action])) {
            return $customMessages[$action];
        }

        if (isset($customMessages[$controller . '.' . $action])) {
            return $customMessages[$controller . '.' . $action];
        }

        // Gera mensagem padrão
        return self::generateDefaultMessage($action, $controller, $userRole);
    }

    /**
     * Gera mensagem padrão baseada na ação e controlador
     * @param string $action
     * @param string $controller
     * @param string $userRole
     * @return string
     */
    public static function generateDefaultMessage($action, $controller, $userRole = null)
    {
        $actionText = self::$defaultMessages[$action] ?? 'Você não tem permissão para executar esta ação.';
        $resourceName = self::$resourceNames[$controller] ?? $controller;
        
        $message = str_replace('{resource}', $resourceName, $actionText);

        // Adiciona contexto da role se disponível
        if ($userRole && isset(self::$roleNames[$userRole])) {
            $roleName = self::$roleNames[$userRole];
            $message = "Como {$roleName}, " . lcfirst($message);
        }

        return $message;
    }

    /**
     * Gera mensagem específica para roles
     * @param string $action
     * @param string $controller
     * @param array $requiredRoles
     * @param string $userRole
     * @return string
     */
    public static function generateRoleSpecificMessage($action, $controller, $requiredRoles, $userRole = null)
    {
        $resourceName = self::$resourceNames[$controller] ?? $controller;
        $actionText = self::$defaultMessages[$action] ?? 'executar esta ação';
        
        $roleNames = [];
        foreach ($requiredRoles as $role) {
            $roleNames[] = self::$roleNames[$role] ?? $role;
        }

        $roleList = implode(', ', $roleNames);
        
        if (count($roleNames) === 1) {
            $message = "Apenas {$roleList} pode {$actionText} {$resourceName}.";
        } else {
            $message = "Apenas {$roleList} podem {$actionText} {$resourceName}.";
        }

        // Adiciona contexto da role atual se disponível
        if ($userRole && isset(self::$roleNames[$userRole])) {
            $currentRoleName = self::$roleNames[$userRole];
            $message = "Como {$currentRoleName}, você não tem permissão. {$message}";
        }

        return $message;
    }

    /**
     * Gera mensagem com sugestão de ação
     * @param string $action
     * @param string $controller
     * @param string $suggestion
     * @return string
     */
    public static function generateMessageWithSuggestion($action, $controller, $suggestion)
    {
        $baseMessage = self::generateDefaultMessage($action, $controller);
        return $baseMessage . ' ' . $suggestion;
    }

    /**
     * Gera mensagem para ações administrativas
     * @param string $action
     * @param string $controller
     * @return string
     */
    public static function generateAdminMessage($action, $controller)
    {
        $resourceName = self::$resourceNames[$controller] ?? $controller;
        $actionText = self::$defaultMessages[$action] ?? 'executar esta ação';
        
        return "Esta é uma ação administrativa. Apenas administradores podem {$actionText} {$resourceName}.";
    }

    /**
     * Gera mensagem para ações que requerem contacto
     * @param string $action
     * @param string $controller
     * @return string
     */
    public static function generateContactMessage($action, $controller)
    {
        $resourceName = self::$resourceNames[$controller] ?? $controller;
        $actionText = self::$defaultMessages[$action] ?? 'executar esta ação';
        
        return "Você não tem permissão para {$actionText} {$resourceName}. Entre em contacto com a administração.";
    }

    /**
     * Retorna todas as mensagens padrão
     * @return array
     */
    public static function getDefaultMessages()
    {
        return self::$defaultMessages;
    }

    /**
     * Retorna todos os nomes de recursos
     * @return array
     */
    public static function getResourceNames()
    {
        return self::$resourceNames;
    }

    /**
     * Retorna todos os nomes de roles
     * @return array
     */
    public static function getRoleNames()
    {
        return self::$roleNames;
    }
} 