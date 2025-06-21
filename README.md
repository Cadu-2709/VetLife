Manual de Instalação e Deployment do Sistema VetLifeEste guia fornece as instruções completas para instalar o sistema VetLife num ambiente de desenvolvimento local e para o configurar num servidor de produção, tornando-o acessível para múltiplos utilizadores.Parte 1: Requisitos do SistemaAntes de começar, certifique-se de que a máquina (seja local ou o servidor) tem o seguinte software instalado:Servidor Web: Apache (recomendado) ou Nginx.PHP: Versão 8.0 ou superior, com as seguintes extensões ativadas:pdo_pgsql (para a ligação com o PostgreSQL)mbstringintlBanco de Dados: PostgreSQL versão 12 ou superior.Composer: O gestor de dependências do PHP.Git: Para clonar o repositório do projeto.Parte 2: Instalação em Ambiente de Desenvolvimento LocalSiga estes passos para configurar o projeto na sua própria máquina para testes ou para continuar o desenvolvimento.Passo 2.1: Obter o Código-FonteAbra o terminal e clone o repositório do projeto a partir do GitHub para a pasta de projetos do seu servidor web (ex: C:/xampp/htdocs/ ou /var/www/html/).# Substitua pela URL do seu repositório
git clone https://github.com/Cadu-2709/VetLife.git

# Navegue para a pasta do projeto
cd VetLife
Passo 2.2: Instalar as Dependências do ProjetoUse o Composer para instalar todas as bibliotecas e o framework Yii2.composer install
Passo 2.3: Configurar o Banco de DadosCrie a Base de Dados: Usando o pgAdmin ou a linha de comando, crie uma base de dados vazia (ex: vetlife_db).Execute o Script SQL Inicial: Execute o script SQL que contém a criação do schema vetlife e de todas as tabelas (client, animal, etc.).Configure a Conexão: Copie o ficheiro /config/db.php.dist para /config/db.php (se existir um .dist) e edite o /config/db.php com os seus dados de acesso ao PostgreSQL:return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=vetlife_db',
    'username' => 'seu_usuario_postgres',
    'password' => 'sua_senha',
    'charset' => 'utf8',
];
Passo 2.4: Executar as MigrationsAs migrations irão configurar tabelas adicionais e, mais importante, criar o utilizador administrador padrão.php yii migrate
Quando perguntado, digite yes e pressione Enter para aplicar a migration.Passo 2.5: Iniciar o Servidor de DesenvolvimentoPara testar localmente, use o servidor embutido do Yii2.php yii serve
O sistema estará agora acessível em http://localhost:8080.Parte 3: Configuração para Produção (Acesso na Rede/Internet)Para que outras pessoas possam utilizar o sistema através do IP da máquina ou de um domínio, não se deve usar o php yii serve. É necessário configurar o servidor web (Apache).Passo 3.1: Configurar o Servidor Web (Exemplo para Apache)É preciso criar um "Virtual Host" que aponte para a pasta /web do seu projeto, que é o ponto de entrada público e seguro do Yii2.Edite o ficheiro de configuração de hosts do Apache (ex: httpd-vhosts.conf).Adicione o seguinte bloco, ajustando os caminhos para a sua realidade:<VirtualHost *:80>
    ServerName vetlife.local # Ou o IP do servidor: 192.168.3.91
    DocumentRoot "C:/xampp/htdocs/VetLife/web"

    <Directory "C:/xampp/htdocs/VetLife/web">
        # Permite o uso de URLs amigáveis (pretty URLs)
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog "C:/xampp/apache/logs/vetlife-error.log"
    CustomLog "C:/xampp/apache/logs/vetlife-access.log" common
</VirtualHost>
Reinicie o serviço do Apache para que as alterações tenham efeito.Passo 3.2: Ajustes de Segurança e Performance do Yii2Desativar o Modo de Debug: No ficheiro /web/index.php, altere o valor da constante YII_DEBUG para false. Isto é crucial para a segurança.defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
Ativar URLs Amigáveis (Opcional): Para ter URLs como /client/create em vez de /index.php?r=client/create, adicione o seguinte ao seu ficheiro /config/web.php, dentro da secção components:'urlManager' => [
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
    ],
],
Passo 3.3: Permissões de Ficheiros (Importante!)O servidor web precisa de permissão para escrever em duas pastas específicas para poder gerir assets (CSS, JS) e logs. Num ambiente Linux, os comandos seriam:# Dar permissão ao servidor web (www-data) para escrever nas pastas
sudo chown -R www-data:www-data /caminho/para/VetLife/runtime
sudo chown -R www-data:www-data /caminho/para/VetLife/web/assets

# Garantir que as permissões estão corretas
sudo chmod -R 775 /caminho/para/VetLife/runtime
sudo chmod -R 775 /caminho/para/VetLife/web/assets
Passo 3.4: Aceder ao SistemaCom tudo configurado, outras pessoas na mesma rede poderão aceder ao sistema através do endereço IP do servidor (ex: http://192.168.3.91). Se configurou um domínio, utilize-o.O login padrão criado pela migration é:Email: admin@vetlife.comPalavra-passe: admin