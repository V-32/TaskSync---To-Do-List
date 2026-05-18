<?php

require_once 'config/db.php';


if (isset($_GET['acao']) && isset($_GET['id'])) {
    $id_tarefa = intval($_GET['id']);
    $acao = $_GET['acao'];

   
    if ($acao === 'excluir') {
        try {
            $sql = "DELETE FROM tarefas WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id_tarefa]);
        } catch (PDOException $e) {
       
        }
    }
    
   
    if ($acao === 'status' && isset($_GET['novo_status'])) {
        $novo_status = $_GET['novo_status'];
        
        
        if (in_array($novo_status, ['a fazer', 'fazendo', 'concluído'])) {
            try {
                $sql = "UPDATE tarefas SET status = :status WHERE id = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':status' => $novo_status, ':id' => $id_tarefa]);
            } catch (PDOException $e) {
                
            }
        }
    }
}


header("Location: index.php");
exit;
?>
