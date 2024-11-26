<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'tarefas_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Tarefas</h1>
        </div>
    </div>

    <div class="row">
        <div class="col text-end">
            <a href="nova_tarefa.php" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i>Nova Tarefa
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Estado</th>
                        <th>Utilizador</th>
                        <th>Criação</th>
                        <th>Execução</th>
                        <th class="text-end">Acções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $tarefas = lerTarefas();
                        foreach ($tarefas as $tarefa) { ?>
                            <tr>
                                <td><?php echo $tarefa['nome'];?></td>
                                <td><?php echo $tarefa['estado'];?></td>
                                <td><?php echo $tarefa['utilizador'];?></td>
                                <td><?php echo $tarefa['data_criacao'];?></td>
                                <td><?php echo $tarefa['data_execucao'];?></td>
                                <td class="text-end">
                                    <a href="ver_tarefa.php?id=<?php echo $tarefa['id'];?>" class="btn btn-secondary">
                                        <i class="fa-solid fa-info fa-fw"></i>
                                    </a>
                                    <a href="modificar_tarefa.php?id=<?php echo $tarefa['id'];?>" class="btn btn-warning">
                                        <i class="fa-solid fa-user-pen fa-fw"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
