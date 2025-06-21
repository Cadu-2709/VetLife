# Sistema de Autorização por Roles

Este documento explica como usar o sistema de autorização baseado em roles implementado no projeto VetLife.

## Visão Geral

O sistema de autorização permite controlar o acesso às funcionalidades do sistema baseado nas roles dos usuários. As roles disponíveis são:

- **admin**: Administrador com acesso total ao sistema
- **veterinarian**: Veterinário com acesso a animais, agendamentos e histórico clínico
- **receptionist**: Recepcionista com acesso a clientes, animais e agendamentos
- **client**: Cliente com acesso limitado aos seus próprios dados

## Componentes Principais

### 1. AuthManager (`app/components/AuthManager.php`)

Componente principal que gerencia a autorização. Fornece métodos para:

- Verificar roles específicas
- Verificar permissões
- Gerenciar permissões por role

### 2. RoleAccessBehavior (`app/behaviors/RoleAccessBehavior.php`)

Behavior que controla o acesso às ações dos controladores baseado em roles.

### 3. BaseController (`app/controllers/BaseController.php`)

Controlador base que outros controladores devem estender para ter funcionalidades de autorização.

### 4. AuthHelper (`app/helpers/AuthHelper.php`)

Helper para facilitar o uso do sistema de autorização nas views.

### 5. ErrorMessageManager (`app/components/ErrorMessageManager.php`)

Componente para gerenciar mensagens de erro de autorização de forma centralizada e personalizada.

## Como Usar

### 1. Configurando um Controlador

Para configurar um controlador com controle de acesso, estenda `BaseController` e defina as permissões:

```php
<?php
namespace app\controllers;

use app\controllers\BaseController;

class MeuController extends BaseController
{
    protected $permissions = [
        'index' => ['admin', 'receptionist'], // Apenas admin e recepcionista podem listar
        'view' => ['admin', 'receptionist', 'veterinarian'], // Admin, recepcionista e veterinário podem ver
        'create' => ['admin', 'receptionist'], // Apenas admin e recepcionista podem criar
        'update' => ['admin', 'receptionist'], // Apenas admin e recepcionista podem editar
        'delete' => ['admin'], // Apenas admin pode excluir
        '*' => ['admin'], // Para todas as outras ações, apenas admin
    ];

    protected $publicActions = ['public-action']; // Ações que não precisam de autenticação

    // Mensagens de erro personalizadas
    protected $customErrorMessages = [
        'index' => 'Apenas administradores e recepcionistas podem visualizar esta lista.',
        'create' => 'Você não tem permissão para criar novos registos.',
        'delete' => 'Apenas administradores podem remover registos do sistema.',
    ];
}
```

### 2. Mensagens de Erro Personalizadas

O sistema oferece três níveis de personalização de mensagens:

#### 2.1 Mensagens Específicas por Ação
```php
protected $customErrorMessages = [
    'index' => 'Mensagem personalizada para listagem',
    'create' => 'Mensagem personalizada para criação',
    'user.create' => 'Mensagem específica para criação de usuários',
];
```

#### 2.2 Mensagens Automáticas Baseadas em Role
O sistema gera automaticamente mensagens como:
- "Como Cliente, você não tem permissão para visualizar usuários."
- "Apenas Administrador, Recepcionista podem editar clientes."

#### 2.3 Usando ErrorMessageManager
```php
use app\components\ErrorMessageManager;

// Gerar mensagem padrão
$message = ErrorMessageManager::generateMessage('create', 'user', 'client');

// Gerar mensagem específica para roles
$message = ErrorMessageManager::generateRoleSpecificMessage(
    'delete', 
    'user', 
    ['admin'], 
    'client'
);

// Gerar mensagem com sugestão
$message = ErrorMessageManager::generateMessageWithSuggestion(
    'create', 
    'scheduling', 
    'Entre em contacto com a recepção.'
);
```

### 3. Usando em Views

Para controlar a exibição de elementos baseado em permissões:

```php
<?php
use app\helpers\AuthHelper;
use yii\helpers\Html;
?>

<!-- Botão visível apenas para quem pode criar -->
<?php if (AuthHelper::can('meu-controller.create')): ?>
    <?= Html::a('Criar Novo', ['create'], ['class' => 'btn btn-success']) ?>
<?php endif; ?>

<!-- Verificar role específica -->
<?php if (AuthHelper::isAdmin()): ?>
    <div class="admin-panel">
        <!-- Conteúdo apenas para administradores -->
    </div>
<?php endif; ?>

<!-- Verificar múltiplas roles -->
<?php if (AuthHelper::hasAnyRole(['admin', 'receptionist'])): ?>
    <div class="staff-panel">
        <!-- Conteúdo para admin e recepcionista -->
    </div>
<?php endif; ?>
```

### 4. Verificações Programáticas

Nos controladores, você pode usar os métodos herdados do `BaseController`:

```php
public function actionMinhaAcao()
{
    // Verificar se o usuário tem uma role específica
    if (!$this->hasRole('admin')) {
        throw new ForbiddenHttpException('Acesso negado');
    }

    // Verificar se o usuário tem uma das roles
    if (!$this->hasAnyRole(['admin', 'receptionist'])) {
        throw new ForbiddenHttpException('Acesso negado');
    }

    // Verificar permissão específica
    if (!$this->can('user.create')) {
        throw new ForbiddenHttpException('Acesso negado');
    }

    // Lançar exceção se não tiver role
    $this->requireRole('admin');

    // Lançar exceção se não tiver uma das roles
    $this->requireAnyRole(['admin', 'receptionist']);
}
```

## Permissões por Role

### Admin
- Acesso total a todas as funcionalidades
- Pode gerenciar usuários, serviços, veterinários
- Pode excluir registros

### Veterinário
- Visualizar e editar agendamentos
- Acesso completo ao histórico clínico
- Visualizar animais e clientes

### Recepcionista
- Gerenciar clientes e animais
- Criar e editar agendamentos
- Visualizar serviços e veterinários

### Cliente
- Visualizar seus próprios animais
- Criar e editar seus próprios agendamentos
- Visualizar seu próprio histórico clínico

## Configuração

O sistema está configurado no arquivo `config/web.php`:

```php
'authManager' => [
    'class' => 'app\components\AuthManager',
],
```

## Exemplos Práticos

### Exemplo 1: Controlador de Usuários
```php
class UserController extends BaseController
{
    protected $permissions = [
        '*' => 'admin', // Todas as ações requerem role admin
    ];

    protected $customErrorMessages = [
        'index' => 'Apenas administradores podem visualizar a lista de usuários do sistema.',
        'create' => 'Apenas administradores podem criar novos usuários no sistema.',
        'delete' => 'Apenas administradores podem remover usuários do sistema.',
    ];
}
```

### Exemplo 2: Controlador de Agendamentos
```php
class SchedulingController extends BaseController
{
    protected $permissions = [
        'index' => ['admin', 'receptionist', 'veterinarian', 'client'],
        'view' => ['admin', 'receptionist', 'veterinarian', 'client'],
        'create' => ['admin', 'receptionist', 'client'],
        'update' => ['admin', 'receptionist', 'veterinarian', 'client'],
        'delete' => ['admin', 'receptionist'],
    ];

    protected $customErrorMessages = [
        'create' => 'Você não tem permissão para criar agendamentos. Entre em contacto com a recepção.',
        'delete' => 'Apenas administradores e recepcionistas podem cancelar agendamentos.',
    ];
}
```

### Exemplo 3: View com Controle de Acesso
```php
<div class="scheduling-index">
    <h1>Agendamentos</h1>
    
    <?php if (AuthHelper::can('scheduling.create')): ?>
        <p>
            <?= Html::a('Criar Agendamento', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif; ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // ... outras colunas
            [
                'class' => ActionColumn::class,
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        if (AuthHelper::can('scheduling.update')) {
                            return Html::a('Editar', $url, ['class' => 'btn btn-warning']);
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]); ?>
</div>
```

## Mensagens de Erro Personalizadas

### Tipos de Mensagens

1. **Mensagens Específicas**: Definidas manualmente no controlador
2. **Mensagens Automáticas**: Geradas automaticamente baseadas na ação e role
3. **Mensagens Contextuais**: Incluem informações sobre roles necessárias

### Exemplos de Mensagens Geradas

- "Como Cliente, você não tem permissão para visualizar usuários."
- "Apenas Administrador pode excluir usuários."
- "Apenas Administrador, Recepcionista podem editar clientes."
- "Você não tem permissão para criar agendamentos. Entre em contacto com a recepção."

### Personalizando Mensagens

```php
// No controlador
protected $customErrorMessages = [
    'create' => 'Mensagem personalizada para criação',
    'user.create' => 'Mensagem específica para criação de usuários',
];

// Usando ErrorMessageManager
$message = ErrorMessageManager::generateAdminMessage('delete', 'user');
$message = ErrorMessageManager::generateContactMessage('create', 'scheduling');
```

## Boas Práticas

1. **Sempre use o BaseController** para controladores que precisam de autorização
2. **Defina permissões específicas** por ação quando possível
3. **Use o AuthHelper** nas views para controlar a exibição de elementos
4. **Teste as permissões** antes de executar ações críticas
5. **Mantenha as permissões atualizadas** conforme o sistema evolui
6. **Use mensagens personalizadas** para melhorar a experiência do usuário
7. **Centralize mensagens comuns** no ErrorMessageManager

## Troubleshooting

### Problema: Usuário não consegue acessar uma página
- Verifique se a role do usuário está correta no banco de dados
- Confirme se as permissões estão configuradas corretamente no controlador
- Verifique se o controlador estende `BaseController`

### Problema: Botões não aparecem na view
- Verifique se está usando `AuthHelper::can()` corretamente
- Confirme se a permissão está definida no `AuthManager`
- Verifique se a sintaxe da permissão está correta (ex: 'controller.action')

### Problema: Erro 403 Forbidden
- Verifique se o usuário está logado
- Confirme se o usuário tem a role necessária
- Verifique se as permissões estão configuradas corretamente

### Problema: Mensagens de erro não personalizadas
- Verifique se as mensagens estão definidas em `$customErrorMessages`
- Confirme se o ErrorMessageManager está sendo usado corretamente
- Verifique se as mensagens estão no formato correto