# Exemplos de Mensagens de Erro Personalizadas

Este documento mostra exemplos práticos de como o sistema de mensagens de erro personalizadas funciona no VetLife.

## Exemplos por Controlador

### 1. UserController

**Configuração:**
```php
protected $permissions = [
    '*' => 'admin', // Todas as ações requerem role admin
];

protected $customErrorMessages = [
    'index' => 'Apenas administradores podem visualizar a lista de usuários do sistema.',
    'view' => 'Apenas administradores podem visualizar detalhes de usuários.',
    'create' => 'Apenas administradores podem criar novos usuários no sistema.',
    'update' => 'Apenas administradores podem editar informações de usuários.',
    'delete' => 'Apenas administradores podem remover usuários do sistema.',
];
```

**Mensagens geradas:**
- Cliente tenta acessar `/user/index`: "Apenas administradores podem visualizar a lista de usuários do sistema."
- Veterinário tenta acessar `/user/create`: "Apenas administradores podem criar novos usuários no sistema."
- Recepcionista tenta acessar `/user/delete`: "Apenas administradores podem remover usuários do sistema."

### 2. SchedulingController

**Configuração:**
```php
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
```

**Mensagens geradas:**
- Veterinário tenta acessar `/scheduling/create`: "Você não tem permissão para criar agendamentos. Entre em contacto com a recepção."
- Cliente tenta acessar `/scheduling/delete`: "Apenas administradores e recepcionistas podem cancelar agendamentos."
- Usuário não logado tenta acessar `/scheduling/index`: Redirecionado para login

### 3. ClientController

**Configuração:**
```php
protected $permissions = [
    '*' => ['admin', 'receptionist'],
];

protected $customErrorMessages = [
    'index' => 'Apenas administradores e recepcionistas podem visualizar a lista de clientes.',
    'view' => 'Apenas administradores e recepcionistas podem visualizar dados de clientes.',
    'create' => 'Apenas administradores e recepcionistas podem cadastrar novos clientes.',
    'update' => 'Apenas administradores e recepcionistas podem editar dados de clientes.',
    'delete' => 'Apenas administradores e recepcionistas podem remover clientes do sistema.',
];
```

**Mensagens geradas:**
- Cliente tenta acessar `/client/index`: "Apenas administradores e recepcionistas podem visualizar a lista de clientes."
- Veterinário tenta acessar `/client/create`: "Apenas administradores e recepcionistas podem cadastrar novos clientes."

### 4. MedicalHistoryController

**Configuração:**
```php
protected $permissions = [
    'index' => ['admin', 'veterinarian', 'client'],
    'view' => ['admin', 'veterinarian', 'client'],
    'create' => ['admin', 'veterinarian'],
    'update' => ['admin', 'veterinarian'],
    'delete' => ['admin'],
];

protected $customErrorMessages = [
    'create' => 'Apenas veterinários e administradores podem criar registos de histórico clínico.',
    'update' => 'Apenas veterinários e administradores podem editar histórico clínico.',
    'delete' => 'Apenas administradores podem remover registos de histórico clínico.',
];
```

**Mensagens geradas:**
- Cliente tenta acessar `/medical-history/create`: "Apenas veterinários e administradores podem criar registos de histórico clínico."
- Recepcionista tenta acessar `/medical-history/update`: "Apenas veterinários e administradores podem editar histórico clínico."
- Veterinário tenta acessar `/medical-history/delete`: "Apenas administradores podem remover registos de histórico clínico."

## Mensagens Automáticas

Quando não há mensagens personalizadas definidas, o sistema gera automaticamente:

### Exemplos de Mensagens Automáticas

1. **Cliente tentando acessar área administrativa:**
   - "Como Cliente, você não tem permissão para visualizar usuários."

2. **Recepcionista tentando excluir registos:**
   - "Como Recepcionista, você não tem permissão para excluir usuários."

3. **Veterinário tentando criar usuários:**
   - "Como Veterinário, você não tem permissão para criar usuários."

## Usando ErrorMessageManager

### Exemplos de Uso

```php
use app\components\ErrorMessageManager;

// 1. Mensagem padrão
$message = ErrorMessageManager::generateMessage('create', 'user', 'client');
// Resultado: "Como Cliente, você não tem permissão para criar usuários."

// 2. Mensagem específica para roles
$message = ErrorMessageManager::generateRoleSpecificMessage(
    'delete', 
    'user', 
    ['admin'], 
    'client'
);
// Resultado: "Como Cliente, você não tem permissão. Apenas Administrador pode excluir usuários."

// 3. Mensagem com sugestão
$message = ErrorMessageManager::generateMessageWithSuggestion(
    'create', 
    'scheduling', 
    'Entre em contacto com a recepção.'
);
// Resultado: "Você não tem permissão para criar agendamentos. Entre em contacto com a recepção."

// 4. Mensagem administrativa
$message = ErrorMessageManager::generateAdminMessage('delete', 'user');
// Resultado: "Esta é uma ação administrativa. Apenas administradores podem excluir usuários."

// 5. Mensagem de contacto
$message = ErrorMessageManager::generateContactMessage('create', 'scheduling');
// Resultado: "Você não tem permissão para criar agendamentos. Entre em contacto com a administração."
```

## Cenários de Teste

### Cenário 1: Cliente tentando acessar área administrativa

1. Cliente faz login
2. Tenta acessar `/user/index`
3. Sistema verifica permissões
4. Retorna: "Apenas administradores podem visualizar a lista de usuários do sistema."

### Cenário 2: Veterinário tentando criar agendamento

1. Veterinário faz login
2. Tenta acessar `/scheduling/create`
3. Sistema verifica permissões
4. Retorna: "Você não tem permissão para criar agendamentos. Entre em contacto com a recepção."

### Cenário 3: Recepcionista tentando excluir histórico clínico

1. Recepcionista faz login
2. Tenta acessar `/medical-history/delete`
3. Sistema verifica permissões
4. Retorna: "Apenas administradores podem remover registos de histórico clínico."

### Cenário 4: Usuário não logado

1. Usuário não logado tenta acessar qualquer área protegida
2. Sistema redireciona para `/site/login`
3. Após login, usuário é redirecionado para a página original

## Benefícios do Sistema

### 1. Experiência do Usuário
- Mensagens claras e específicas
- Informação sobre quem pode executar a ação
- Sugestões de contacto quando apropriado

### 2. Manutenibilidade
- Mensagens centralizadas no ErrorMessageManager
- Fácil personalização por controlador
- Reutilização de mensagens comuns

### 3. Segurança
- Mensagens não revelam informações sensíveis
- Consistência nas mensagens de erro
- Logs de tentativas de acesso não autorizado

### 4. Flexibilidade
- Três níveis de personalização
- Suporte a múltiplos idiomas (futuro)
- Fácil extensão para novos tipos de mensagem

## Boas Práticas

1. **Use mensagens específicas** para ações críticas
2. **Mantenha mensagens claras** e em português
3. **Inclua sugestões** quando apropriado
4. **Teste mensagens** com diferentes roles
5. **Centralize mensagens comuns** no ErrorMessageManager
6. **Mantenha consistência** no tom das mensagens 