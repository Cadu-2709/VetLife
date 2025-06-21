<?php

namespace app\behaviors;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use app\components\ErrorMessageManager;

/**
 * Behavior para controle de acesso baseado em roles
 * Permite definir permissões por ação do controlador
 */
class RoleAccessBehavior extends ActionFilter
{
    /**
     * @var array Configuração de permissões por ação
     * Formato: [
     *     'actionName' => ['role1', 'role2'],
     *     'actionName' => 'role1',
     *     '*' => ['role1', 'role2'], // Para todas as ações
     * ]
     */
    public $permissions = [];

    /**
     * @var array Ações que não precisam de autenticação
     */
    public $publicActions = [];

    /**
     * @var string Mensagem de erro personalizada
     */
    public $errorMessage = 'Acesso negado. Você não tem permissão para acessar esta página.';

    /**
     * @var array Mensagens de erro personalizadas por ação
     * Formato: [
     *     'actionName' => 'Mensagem personalizada',
     *     'controller.action' => 'Mensagem personalizada',
     * ]
     */
    public $customErrorMessages = [];

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $actionId = $action->id;

        // Se a ação é pública, permite acesso
        if (in_array($actionId, $this->publicActions)) {
            return true;
        }

        // Se o usuário não está logado, redireciona para login
        if (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
            return false;
        }

        // Verifica permissões específicas da ação
        if (isset($this->permissions[$actionId])) {
            $requiredRoles = $this->permissions[$actionId];
            if (is_string($requiredRoles)) {
                $requiredRoles = [$requiredRoles];
            }

            if (!$this->hasAnyRole($requiredRoles)) {
                $message = $this->getCustomErrorMessage($action, $requiredRoles);
                throw new ForbiddenHttpException($message);
            }
        }
        // Verifica permissões globais (*)
        elseif (isset($this->permissions['*'])) {
            $requiredRoles = $this->permissions['*'];
            if (is_string($requiredRoles)) {
                $requiredRoles = [$requiredRoles];
            }

            if (!$this->hasAnyRole($requiredRoles)) {
                $message = $this->getCustomErrorMessage($action, $requiredRoles);
                throw new ForbiddenHttpException($message);
            }
        }

        return true;
    }

    /**
     * Verifica se o usuário tem uma das roles especificadas
     * @param array $roles
     * @return bool
     */
    protected function hasAnyRole($roles)
    {
        $userRole = Yii::$app->user->identity->role;
        return in_array($userRole, $roles);
    }

    /**
     * Obtém mensagem de erro personalizada para a ação
     * @param \yii\base\Action $action
     * @param array $requiredRoles
     * @return string
     */
    protected function getCustomErrorMessage($action, $requiredRoles = [])
    {
        $actionKey = $action->id;
        $controllerKey = $action->controller->id . '.' . $action->id;
        $userRole = Yii::$app->user->identity->role;
        
        // Verifica se existe mensagem específica para a ação
        if (isset($this->customErrorMessages[$actionKey])) {
            return $this->customErrorMessages[$actionKey];
        }
        
        // Verifica se existe mensagem específica para controller.action
        if (isset($this->customErrorMessages[$controllerKey])) {
            return $this->customErrorMessages[$controllerKey];
        }
        
        // Usa o ErrorMessageManager para gerar mensagem contextual
        if (!empty($requiredRoles)) {
            return ErrorMessageManager::generateRoleSpecificMessage(
                $action->id,
                $action->controller->id,
                $requiredRoles,
                $userRole
            );
        }
        
        // Retorna mensagem padrão baseada na ação
        return ErrorMessageManager::generateMessage(
            $action->id,
            $action->controller->id,
            $userRole,
            $this->customErrorMessages
        );
    }
}