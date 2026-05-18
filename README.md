# TaskSync - Sistema de Gerenciamento de Tarefas

O TaskSync é uma aplicação web simples para gerenciamento de projetos baseada no conceito de "To Do List" (quadro visual Kanban). O sistema permite o cadastro de colaboradores, a distribuição e edição de demandas divididas por setores e prioridades, além da movimentação dinâmica de tarefas entre os status "A Fazer", "Fazendo" e "Concluído".

---

## Credenciais de Acesso (Admin)

De acordo com as regras de negócio especificadas no escopo do projeto, o sistema não exige controle de login, telas de autenticação ou restrições de níveis de acesso para a utilização de suas funcionalidades. 

Caso o ambiente de hospedagem ou a avaliação exija parâmetros de autenticação prévia no servidor local, utilize as seguintes credenciais padrão:

* **Usuário Admin:** admin
* **Senha:** admin123

---

## Pré-requisitos e Bibliotecas

A aplicação foi desenvolvida utilizando tecnologias nativas, visando o desempenho e a simplicidade de implantação.

* **Bibliotecas externas:** Não há necessidade de instalar nenhuma biblioteca, framework (como Bootstrap) ou gerenciador de pacotes (como Composer/NPM).
* **Tecnologias utilizadas:** HTML5, CSS3, JavaScript estruturado e PHP 8.x (utilizando a extensão PDO para conexão com o banco de dados).
* **Banco de Dados:** MySQL.

---

## Instruções para Instalação e Teste

Siga os passos abaixo para executar a aplicação localmente:

### 1. Clonar ou Extrair o Projeto
Coloque a pasta completa do projeto (`tasksync`) dentro do diretório de arquivos públicos do seu servidor local. 
* No XAMPP: `C:/xampp/htdocs/tasksync/`
* No WampServer: `C:/wamp64/www/tasksync/`

### 2. Configurar o Banco de Dados
1. Certifique-se de que o serviço do MySQL está ativo no painel de controle do seu servidor local (XAMPP/Wamp).
2. Acesse a interface de gerenciamento do banco de dados pelo navegador através do endereço: `http://localhost/phpmyadmin/`
3. Vá até a aba "SQL".
4. Copie todo o conteúdo presente no arquivo `script.sql` (localizado na pasta do projeto) e cole no campo de texto do phpMyAdmin.
5. Clique em "Executar" para que o banco de dados `tasksync_db` e as respectivas tabelas (`usuarios` e `tarefas`) sejam criados automaticamente com seus relacionamentos.

### 3. Verificar a Conexão
Caso as credenciais do seu ambiente local do MySQL sejam diferentes do padrão (Usuário: `root` e Sem Senha), abra o arquivo `db.php` localizado na raiz do projeto e ajuste as variáveis correspondentes:
* `$username = 'seu_usuario';`
* `$password = 'sua_senha';`

### 4. Acessar a Aplicação
Abra o navegador de sua preferência e digite a URL abaixo para acessar o painel de gerenciamento:
`http://localhost/tasksync/index.php`

---

## Fluxo Recomendado para Testes

Para validar todas as regras de negócio implementadas, siga esta sequência no sistema:
1. Acesse a aba **Cadastrar Usuário** e registre ao menos dois colaboradores informando nome, e-mail e setor.
2. Acesse a aba **Nova Tarefa**, selecione um dos colaboradores cadastrados, defina a descrição, o setor da demanda e a prioridade correspondente.
3. No **Painel de Tarefas** (index.php), observe a tarefa criada listada na coluna "A Fazer" com a cor lateral indicando o nível de prioridade.
4. Utilize o botão **Começar** para mover a tarefa para a coluna "Fazendo".
5. Na coluna "Fazendo", teste a opção de retornar o status clicando em **Voltar** ou avançar para a finalização clicando em **Concluir**.
6. Realize alterações nas informações gerais utilizando o botão **Editar** e teste a remoção completa de um registro através do botão **Excluir**.