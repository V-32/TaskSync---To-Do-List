
CREATE DATABASE IF NOT EXISTS `tasksync_db` 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;


USE `tasksync_db`;


CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `setor` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `tarefas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `descricao` TEXT NOT NULL,
    `setor` VARCHAR(50) NOT NULL,
    `prioridade` ENUM('baixa', 'média', 'alta') NOT NULL,
    `data_cadastro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `status` ENUM('a fazer', 'fazendo', 'concluído') DEFAULT 'a fazer',
    
   
    CONSTRAINT `fk_tarefa_usuario` 
        FOREIGN KEY (`usuario_id`) 
        REFERENCES `usuarios` (`id`) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;