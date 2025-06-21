<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\behaviors\RoleAccessBehavior;

/**
 * Controlador base com funcionalidades de autorização
 * Outros controladores devem estender esta classe
 */
abstract class BaseController extends Controller
{
    /**
     * @var array Configuração de permissões por ação
     * Deve ser sobrescrito pelos controladores filhos
     */
    protected $permissions = [];

    /**
     * @var array Ações que não precisam de autenticação
     */
    protected $publicActions = [];

    /**
     * @var array Mensagens de erro personalizadas por ação
     * Formato: [
     *     'actionName' => 'Mensagem personalizada',
     *     'controller.action' => 'Mensagem personalizada',
     * ]
     */
    protected $customErrorMessages = [];

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'roleAccess' => [
                'class' => RoleAccessBehavior::class,
                'permissions' => $this->permissions,
                'publicActions' => $this->publicActions,
                'customErrorMessages' => $this->customErrorMessages,
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => $this->getVerbActions(),
            ],
        ];
    }

    /**
     * Retorna as ações que precisam de filtros de verbos HTTP
     * @return array
     */
    protected function getVerbActions()
    {
        return [
            'delete' => ['POST'],
        ];
    }

    /**
     * Verifica se o usuário tem permissão para uma ação específica
     * @param string $permission
     * @return bool
     */
    protected function can($permission)
    {
        return Yii::$app->authManager->can($permission);
    }

    /**
     * Verifica se o usuário tem uma das roles especificadas
     * @param array $roles
     * @return bool
     */
    protected function hasAnyRole($roles)
    {
        return Yii::$app->authManager->hasAnyRole($roles);
    }

    /**
     * Verifica se o usuário tem a role especificada
     * @param string $role
     * @return bool
     */
    protected function hasRole($role)
    {
        return Yii::$app->authManager->hasRole($role);
    }

    /**
     * Verifica se o usuário é administrador
     * @return bool
     */
    protected function isAdmin()
    {
        return Yii::$app->authManager->isAdmin();
    }

    /**
     * Verifica se o usuário é veterinário
     * @return bool
     */
    protected function isVeterinarian()
    {
        return Yii::$app->authManager->isVeterinarian();
    }

    /**
     * Verifica se o usuário é recepcionista
     * @return bool
     */
    protected function isReceptionist()
    {
        return Yii::$app->authManager->isReceptionist();
    }

    /**
     * Verifica se o usuário é cliente
     * @return bool
     */
    protected function isClient()
    {
        return Yii::$app->authManager->isClient();
    }

    /**
     * Lança exceção se o usuário não tiver a role especificada
     * @param string $role
     * @throws \yii\web\ForbiddenHttpException
     */
    protected function requireRole($role)
    {
        Yii::$app->authManager->requireRole($role);
    }

    /**
     * Lança exceção se o usuário não tiver uma das roles especificadas
     * @param array $roles
     * @throws \yii\web\ForbiddenHttpException
     */
    protected function requireAnyRole($roles)
    {
        Yii::$app->authManager->requireAnyRole($roles);
    }
}