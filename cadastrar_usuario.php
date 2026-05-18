<?php

require_once 'config/db.php';


$mensagem_sucesso = "";
$mensagem_erro = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $setor = trim($_POST['setor']);

   
    if (!empty($nome) && !empty($email) && !empty($setor)) {
        try {
            
            $sql = "INSERT INTO usuarios (nome, email, setor) VALUES (:nome, :email, :setor)";
            $stmt = $pdo->prepare($sql);
            
            
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':setor' => $setor
            ]);

            $mensagem_sucesso = "Usuário cadastrado com sucesso!";
        } catch (PDOException $e) {
            $mensagem_erro = "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    } else {
        $mensagem_erro = "Por favor, preencha todos os campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Cadastrar Usuário</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-cadastro-usuario">

    <header class="main-header">
        <div class="header-container">
            <div class="logo-area">
                <span class="logo-text">TaskSync</span>
            </div>
            <nav class="main-nav">
                <a href="index.php" class="nav-link">Painel de Tarefas</a>
                <a href="cadastrar_usuario.php" class="nav-link active">Cadastrar Usuário</a>
                <a href="cadastrar_tarefa.php" class="nav-link">Nova Tarefa</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <section class="form-section">
            <div class="form-card">
                <h2 class="form-title">Cadastro de Novo Usuário</h2>
                <p class="form-subtitle">Registre os colaboradores para que possam receber tarefas.</p>

                <?php if (!empty($mensagem_sucesso)): ?>
                    <div class="alert alert-success"><?php echo $mensagem_sucesso; ?></div>
                <?php endif; ?>

                <?php if (!empty($mensagem_erro)): ?>
                    <div class="alert alert-danger"><?php echo $mensagem_erro; ?></div>
                <?php endif; ?>

                <form action="cadastrar_usuario.php" method="POST" class="custom-form">
                    
                    <div class="form-group">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" id="nome" name="nome" class="form-input" placeholder="Digite o nome do colaborador" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">E-mail Corporativo</label>
                        <input type="email" id="email" name="email" class="form-input" placeholder="exemplo@empresa.com" required>
                    </div>

                    <div class="form-group">
                        <label for="setor" class="form-label">Setor da Empresa</label>
                        <input type="text" id="setor" name="setor" class="form-input" placeholder="Ex: TI, RH, Marketing, Financeiro" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Cadastrar Usuário</button>
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    </div>

                </form>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 TaskSync Solutions. Todos os direitos reservados.</p>
    </footer>

</body>
</html>
