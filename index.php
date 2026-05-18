<?php

require_once 'db.php';


$mensagem_sucesso = "";
$mensagem_erro = "";


try {
    $sql = "SELECT t.*, u.nome AS responsavel 
            FROM tarefas t 
            INNER JOIN usuarios u ON t.usuario_id = u.id 
            ORDER BY t.data_cadastro DESC";
    $stmt = $pdo->query($sql);
    $todas_tarefas = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erro ao carregar o painel: " . $e->getMessage());
}


$coluna_a_fazer = [];
$coluna_fazendo = [];
$coluna_concluido = [];

foreach ($todas_tarefas as $tarefa) {
    if ($tarefa['status'] === 'a fazer') {
        $coluna_a_fazer[] = $tarefa;
    } elseif ($tarefa['status'] === 'fazendo') {
        $coluna_fazendo[] = $tarefa;
    } elseif ($tarefa['status'] === 'concluído') {
        $coluna_concluido[] = $tarefa;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskSync - Gerenciamento de Tarefas</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-dashboard">

    <header class="main-header">
        <div class="header-container">
            <div class="logo-area">
                <span class="logo-text">TaskSync</span>
            </div>
            <nav class="main-nav">
                <a href="index.php" class="nav-link active">Painel de Tarefas</a>
                <a href="cadastrar_usuario.php" class="nav-link">Cadastrar Usuário</a>
                <a href="cadastrar_tarefa.php" class="nav-link">Nova Tarefa</a>
            </nav>
        </div>
    </header>

    <main class="main-content-dashboard">
        
        <div class="dashboard-header">
            <h1 class="dashboard-title">Quadro de Projetos</h1>
            <p class="dashboard-subtitle">Acompanhe e movimente o fluxo de trabalho da sua equipe.</p>
        </div>

        <?php if (!empty($mensagem_erro)): ?>
            <div class="alert alert-danger"><?php echo $mensagem_erro; ?></div>
        <?php endif; ?>

        <div class="kanban-board">

            <section class="kanban-column col-todo">
                <div class="column-header">
                    <h3 class="column-title">A Fazer</h3>
                    <span class="badge-count"><?php echo count($coluna_a_fazer); ?></span>
                </div>
                <div class="column-cards">
                    <?php if (empty($coluna_a_fazer)): ?>
                        <p class="empty-message">Nenhuma tarefa pendente.</p>
                    <?php else: ?>
                        <?php foreach ($coluna_a_fazer as $tar): ?>
                            <div class="task-card priority-<?php echo $tar['prioridade']; ?>">
                                <span class="card-sector"><?php echo htmlspecialchars($tar['setor']); ?></span>
                                <p class="card-description"><?php echo htmlspecialchars($tar['descricao']); ?></p>
                                <div class="card-meta">
                                    <span class="card-user">👤 <?php echo htmlspecialchars($tar['responsavel']); ?></span>
                                    <span class="card-date">📅 <?php echo date('d/m/Y', strtotime($tar['data_cadastro'])); ?></span>
                                </div>
                                <div class="card-actions">
                                    <a href="acoes_tarefa.php?acao=status&id=<?php echo $tar['id']; ?>&novo_status=fazendo" class="btn-action btn-move" title="Iniciar Tarefa">Começar ➜</a>
                                    <div class="card-sub-actions">
                                        <a href="editar_tarefa.php?id=<?php echo $tar['id']; ?>" class="btn-sub-edit">Editar</a>
                                        <a href="acoes_tarefa.php?acao=excluir&id=<?php echo $tar['id']; ?>" class="btn-sub-delete" onclick="return confirm('Deseja realmente excluir esta tarefa?')">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="kanban-column col-doing">
                <div class="column-header">
                    <h3 class="column-title">Fazendo</h3>
                    <span class="badge-count"><?php echo count($coluna_fazendo); ?></span>
                </div>
                <div class="column-cards">
                    <?php if (empty($coluna_fazendo)): ?>
                        <p class="empty-message">Nenhuma tarefa em execução.</p>
                    <?php else: ?>
                        <?php foreach ($coluna_fazendo as $tar): ?>
                            <div class="task-card priority-<?php echo $tar['prioridade']; ?>">
                                <span class="card-sector"><?php echo htmlspecialchars($tar['setor']); ?></span>
                                <p class="card-description"><?php echo htmlspecialchars($tar['descricao']); ?></p>
                                <div class="card-meta">
                                    <span class="card-user">👤 <?php echo htmlspecialchars($tar['responsavel']); ?></span>
                                    <span class="card-date">📅 <?php echo date('d/m/Y', strtotime($tar['data_cadastro'])); ?></span>
                                </div>
                                <div class="card-actions inline-actions">
                                    <a href="acoes_tarefa.php?acao=status&id=<?php echo $tar['id']; ?>&novo_status=a fazer" class="btn-action btn-back" title="Voltar para A Fazer">⬅ Voltar</a>
                                    <a href="acoes_tarefa.php?acao=status&id=<?php echo $tar['id']; ?>&novo_status=concluído" class="btn-action btn-complete" title="Concluir Tarefa">Concluir ✔</a>
                                </div>
                                <div class="card-sub-actions group-bottom">
                                    <a href="editar_tarefa.php?id=<?php echo $tar['id']; ?>" class="btn-sub-edit">Editar</a>
                                    <a href="acoes_tarefa.php?acao=excluir&id=<?php echo $tar['id']; ?>" class="btn-sub-delete" onclick="return confirm('Deseja realmente excluir esta tarefa?')">Excluir</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <section class="kanban-column col-done">
                <div class="column-header">
                    <h3 class="column-title">Concluído</h3>
                    <span class="badge-count"><?php echo count($coluna_concluido); ?></span>
                </div>
                <div class="column-cards">
                    <?php if (empty($coluna_concluido)): ?>
                        <p class="empty-message">Nenhuma tarefa finalizada ainda.</p>
                    <?php else: ?>
                        <?php foreach ($coluna_concluido as $tar): ?>
                            <div class="task-card task-done priority-<?php echo $tar['prioridade']; ?>">
                                <span class="card-sector"><?php echo htmlspecialchars($tar['setor']); ?></span>
                                <p class="card-description"><?php echo htmlspecialchars($tar['descricao']); ?></p>
                                <div class="card-meta">
                                    <span class="card-user">👤 <?php echo htmlspecialchars($tar['responsavel']); ?></span>
                                    <span class="card-date">📅 <?php echo date('d/m/Y', strtotime($tar['data_cadastro'])); ?></span>
                                </div>
                                <div class="card-actions">
                                    <a href="acoes_tarefa.php?acao=status&id=<?php echo $tar['id']; ?>&novo_status=fazendo" class="btn-action btn-reopen" title="Reabrir Tarefa">↩ Reabrir</a>
                                    <div class="card-sub-actions">
                                        <a href="editar_tarefa.php?id=<?php echo $tar['id']; ?>" class="btn-sub-edit">Editar</a>
                                        <a href="acoes_tarefa.php?acao=excluir&id=<?php echo $tar['id']; ?>" class="btn-sub-delete" onclick="return confirm('Deseja realmente excluir esta tarefa?')">Excluir</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

        </div>
    </main>

    <footer class="main-footer">
        <p>&copy; 2026 TaskSync Solutions. Todos os direitos reservados.</p>
    </footer>

</body>
</html>