# Instruções de Instalação e Execução - TaskSync

Este documento orienta o passo a passo para configurar e executar a aplicação TaskSync em um ambiente de desenvolvimento local utilizando o servidor XAMPP e o editor Visual Studio Code (VS Code).

---

## Pré-requisitos Obrigatórios

Antes de iniciar a configuração, certifique-se de ter instalado em sua máquina:
* **XAMPP Control Panel** (com suporte a PHP 8.x e MySQL).
* **Visual Studio Code** (ou outro editor de código de sua preferência).

---

## Passo 1: Extração do Projeto no Servidor Local (XAMPP)

1. Faça o download do arquivo compactado (`.zip`) do projeto.
2. Navegue até o diretório de arquivos públicos do seu XAMPP. Por padrão, o caminho no Windows é:
   `C:\xampp\htdocs\`
3. Mova o arquivo `.zip` para dentro da pasta `htdocs`.
4. Extraia o conteúdo do arquivo compactado diretamente neste local. 
5. Certifique-se de que a pasta extraída possua o nome exato de `TaskSync---To-Do-List-main` para evitar falhas nos links internos do sistema.

---

## Passo 2: Inicialização dos Serviços no XAMPP

1. Abra o painel de controle do XAMPP (**XAMPP Control Panel**).
2. Localize os módulos **Apache** e **MySQL**.
3. Clique no botão **Start** ao lado de cada um desses dois módulos e aguarde até que os nomes fiquem destacados na cor verde, indicando que os serviços estão ativos.

---

## Passo 3: Configuração do Banco de Dados no MySQL

1. Abra a pasta `database` que está localizada dentro do diretório do projeto extraído (`C:\xampp\htdocs\TaskSync---To-Do-List-main\database\`).
2. Abra o arquivo `script.sql` utilizando o Bloco de Notas ou o seu editor de código.
3. Selecione todo o texto do arquivo (Ctrl + A) e copie o código (Ctrl + C).
4. Abra o seu navegador de internet e acesse a interface do phpMyAdmin pelo endereço:
   `http://localhost/phpmyadmin/`
5. No menu superior da tela, clique na aba **SQL**.
6. Cole o código copiado no campo de texto de consultas.
7. Clique no botão **Executar** (localizado no canto inferior direito). Este comando criará automaticamente o banco de dados `tasksync_db` junto com as tabelas de usuários e tarefas estruturadas.

---

## Passo 4: Execução do Projeto no VS Code e Navegador

1. Abra o **Visual Studio Code**.
2. Vá em **File** > **Open Folder** (Arquivo > Abrir Pasta) e selecione a pasta do projeto localizada em `C:\xampp\htdocs\TaskSync---To-Do-List-main\`.
3. Com o projeto aberto no editor, você poderá visualizar e gerenciar todos os arquivos `.php` e `.css`.
4. Para visualizar a aplicação rodando no navegador, certifique-se de que o Apache continua ligado no XAMPP e acesse a seguinte URL:
   `http://localhost/tasksync/index.php`

---

## Credenciais de Acesso de Segurança

O sistema foi desenvolvido para operar em ambiente local sem travas de autenticação obrigatória nas páginas. Caso o seu servidor ou o ambiente de avaliação exija credenciais de administrador por padrão, utilize os dados abaixo:

* **Usuário:** admin
* **Senha:** admin123
