<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'tarefas_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (!empty($_POST)) {
        $tarefa = adicionarTarefa($_POST['name'], $_POST['descricao'], $_SESSION['username']);        
        if ($tarefa === false) {
            $message = 'Não foi possivel adicionar a tarefa';
            $class = "danger";
        } else {
            $message = "Tarefa adicionada com sucesso";
            $class = "success";
        }
    }
?>

<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Adicionar Tarefa</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?> 
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="nova_tarefa.php" method="post" class="">
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nome</label>
            <div class="col-4">
                <input class="form-control" type="text" name="name" id="">
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Descrição</label>
            <div class="col-4">
                <textarea class="form-control" name="descricao" id="" cols="30" rows="10"></textarea>
            </div>
        </div>

        
        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input  class="btn btn-success btn-large" type="submit" value="Guardar" name="form_b">
            </div>
        </div>
    </form>
</div>


