<?php

require_once 'config/db.php';


$mensagem_sucesso = "";
$mensagem_erro = "";


if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_tarefa = intval($_GET['id']);


try {
    $sql_usuarios = "SELECT id, nome, setor FROM usuarios ORDER BY nome ASC";
    $stmt_usuarios = $pdo->query($sql_usuarios);
    $usuarios = $stmt_usuarios->fetchAll();
} catch (PDOException $e) {
    $mensagem_erro = "Erro ao carregar usuários: " . $e->getMessage();
}


try {
    $sql_tarefa = "SELECT * FROM tarefas WHERE id = :id";
    $stmt_tarefa = $pdo->prepare($sql_tarefa);
    $stmt_tarefa->execute([':id' => $id_tarefa]);
    $tarefa_atual = $stmt_tarefa->fetch();

  
    if (!$tarefa_atual) {
        header("Location: index.php");
        exit;
    }
} catch (PDOException $e) {
    $mensagem_erro = "Erro ao carregar dados da tarefa: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = trim($_POST['usuario_id']);
    $descricao = trim($_POST['descricao']);
    $setor = trim($_POST['setor']);
    $prioridade = trim($_POST['prioridade']);

   
    if (!empty($usuario_id) && !empty($descricao) && !empty($setor) && !empty($prioridade)) {
        try {
            $sql_update = "UPDATE tarefas 
                           SET usuario_id = :usuario_id, descricao = :descricao, setor = :setor, prioridade = :prioridade 
                           WHERE id = :id";
            
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([
                ':usuario_id' => $usuario_id,
                ':descricao'  => $descricao,
                ':setor'      => $setor,
                ':prioridade' => $prioridade,
                ':id'         => $id_tarefa
            ]);

           
            $tarefa_atual['usuario_id'] = $usuario_id;
            $tarefa_atual['descricao'] = $descricao;
            $tarefa_atual['setor'] = $setor;
            $tarefa_atual['prioridade'] = $prioridade;

            $mensagem_sucesso = "Tarefa atualizada com sucesso!";
        } catch (PDOException $e) {
            $mensagem_erro = "Erro ao atualizar tarefa: " . $e->getMessage();
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
    <title>TaskSync - Editar Tarefa</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-editar-tarefa">

    <header class="main-header">
        <div class="header-container">
            <div class="logo-area">
                <span class="logo-text">TaskSync</span>
            </div>
            <nav class="main-nav">
                <a href="index.php" class="nav-link">Painel de Tarefas</a>
                <a href="cadastrar_usuario.php" class="nav-link">Cadastrar Usuário</a>
                <a href="cadastrar_tarefa.php" class="nav-link">Nova Tarefa</a>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <section class="form-section">
            <div class="form-card">
                <h2 class="form-title">Editar Detalhes da Tarefa</h2>
                <p class="form-subtitle">Modifique as informações necessárias nos campos abaixo.</p>

                <?php if (!empty($mensagem_sucesso)): ?>
                    <div class="alert alert-success"><?php echo $mensagem_sucesso; ?></div>
                <?php endif; ?>

                <?php if (!empty($mensagem_erro)): ?>
                    <div class="alert alert-danger"><?php echo $mensagem_erro; ?></div>
                <?php endif; ?>

                <form action="editar_tarefa.php?id=<?php echo $id_tarefa; ?>" method="POST" class="custom-form">
                    
                    <div class="form-group">
                        <label for="usuario_id" class="form-label">Colaborador Responsável</label>
                        <select id="usuario_id" name="usuario_id" class="form-select-input" required>
                            <?php foreach ($usuarios as $usr): ?>
                                <option value="<?php echo $usr['id']; ?>" <?php echo ($usr['id'] == $tarefa_atual['usuario_id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($usr['nome']) . " (" . htmlspecialchars($usr['setor']) . ")"; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição da Tarefa</label>
                        <textarea id="descricao" name="descricao" class="form-textarea" rows="4" required><?php echo htmlspecialchars($tarefa_atual['descricao']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="setor" class="form-label">Setor Destinado</label>
                        <input type="text" id="setor" name="setor" class="form-input" value="<?php echo htmlspecialchars($tarefa_atual['setor']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="prioridade" class="form-label">Nível de Prioridade</label>
                        <select id="prioridade" name="prioridade" class="form-select-input" required>
                            <option value="baixa" <?php echo ($tarefa_atual['prioridade'] === 'baixa') ? 'selected' : ''; ?>>Baixa</option>
                            <option value="média" <?php echo ($tarefa_atual['prioridade'] === 'média') ? 'selected' : ''; ?>>Média</option>
                            <option value="alta" <?php echo ($tarefa_atual['prioridade'] === 'alta') ? 'selected' : ''; ?>>Alta</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
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
