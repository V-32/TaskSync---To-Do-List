<?php

require_once 'db.php';


$mensagem_sucesso = "";
$mensagem_erro = "";


try {
    $sql_usuarios = "SELECT id, nome, setor FROM usuarios ORDER BY nome ASC";
    $stmt_usuarios = $pdo->query($sql_usuarios);
    $usuarios = $stmt_usuarios->fetchAll();
} catch (PDOException $e) {
    $mensagem_erro = "Erro ao carregar usuários: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = trim($_POST['usuario_id']);
    $descricao = trim($_POST['descricao']);
    $setor = trim($_POST['setor']);
    $prioridade = trim($_POST['prioridade']);

   
    if (!empty($usuario_id) && !empty($descricao) && !empty($setor) && !empty($prioridade)) {
        try {
         
            $sql_inserir = "INSERT INTO tarefas (usuario_id, descricao, setor, prioridade, status) 
                            VALUES (:usuario_id, :descricao, :setor, :prioridade, 'a fazer')";
            
            $stmt_inserir = $pdo->prepare($sql_inserir);
            $stmt_inserir->execute([
                ':usuario_id' => $usuario_id,
                ':descricao'  => $descricao,
                ':setor'      => $setor,
                ':prioridade' => $prioridade
            ]);

            $mensagem_sucesso = "Tarefa cadastrada com sucesso e iniciada como 'A Fazer'!";
        } catch (PDOException $e) {
            $mensagem_erro = "Erro ao cadastrar tarefa: " . $e->getMessage();
        }
    } else {
        $mensagem_erro = "Por favor, preencha todos os campos obrigatórios.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Cadastrar Tarefa</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-cadastro-tarefa">

    <header class="main-header">
        <div class="header-container">
            <div class="logo-area">
                <span class="logo-text">TaskSync</span>
            </div>
            <nav class="main-nav">
                <a href="index.php" class="nav-link">Painel de Tarefas</a>
                <a href="cadastrar_usuario.php" class="nav-link">Cadastrar Usuário</a>
                <a href="cadastrar_tarefa.php" class="nav-link active">Nova Tarefa</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <section class="form-section">
            <div class="form-card">
                <h2 class="form-title">Cadastro de Nova Tarefa</h2>
                <p class="form-subtitle">Preencha as informações para adicionar uma demanda ao quadro visual.</p>

                <?php if (!empty($mensagem_sucesso)): ?>
                    <div class="alert alert-success"><?php echo $mensagem_sucesso; ?></div>
                <?php endif; ?>

                <?php if (!empty($mensagem_erro)): ?>
                    <div class="alert alert-danger"><?php echo $mensagem_erro; ?></div>
                <?php endif; ?>

                <form action="cadastrar_tarefa.php" method="POST" class="custom-form">
                    
                    <div class="form-group">
                        <label for="usuario_id" class="form-label">Colaborador Responsável</label>
                        <select id="usuario_id" name="usuario_id" class="form-select-input" required>
                            <option value="">-- Selecione o Responsável --</option>
                            <?php foreach ($usuarios as $usr): ?>
                                <option value="<?php echo $usr['id']; ?>">
                                    <?php echo htmlspecialchars($usr['nome']) . " (" . htmlspecialchars($usr['setor']) . ")"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição da Tarefa</label>
                        <textarea id="descricao" name="descricao" class="form-textarea" rows="4" placeholder="Descreva o que precisa ser feito..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="setor" class="form-label">Setor Destinado</label>
                        <input type="text" id="setor" name="setor" class="form-input" placeholder="Ex: TI, Operações, Comercial" required>
                    </div>

                    <div class="form-group">
                        <label for="prioridade" class="form-label">Nível de Prioridade</label>
                        <select id="prioridade" name="prioridade" class="form-select-input" required>
                            <option value="">-- Selecione a Prioridade --</option>
                            <option value="baixa">Baixa</option>
                            <option value="média">Média</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Cadastrar Tarefa</button>
                        <a href="index.php" class="btn btn-secondary">Voltar ao Painel</a>
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