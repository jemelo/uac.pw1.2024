<?php
    include_once 'lib' . DIRECTORY_SEPARATOR . 'utilizadores_lib.php';
    include_once 'lib' . DIRECTORY_SEPARATOR . 'tarefas_lib.php';

    if (!validaSessao()) {
        header('Location: login.php');
        exit;
    }

    if (empty($_GET['id'])) {
        $message = 'É obrigatório indicar a tarefa.';
        $class = "danger";
    } else {
        $tarefa = obtemTarefa($_GET['id']);
        if ($tarefa === false) {
            $message = 'A tarefa indicada não foi encontrada';
            $class = "danger";
        } else {
            if (!empty($_POST)) {
                try {
                    modificarTarefa($_GET['id'], $_POST['name'], $_POST['descricao'], $_POST['data_execucao']);
                    $message = "Tarefa modificada com sucesso";
                    $class = "success";
                    $tarefa = obtemTarefa($_GET['id']);
                } catch (Exception $e) {
                    $message = $e->getMessage();
                    $class = "danger";

                }
                
            }
        }
    }
?>
  
  <?php include_once 'partials' . DIRECTORY_SEPARATOR . 'header.php'; ?>
<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'menu.php'; ?>

<div class="container mt-3">
    <div class="row">
        <div class="col">
            <h1>Modificar Tarefa</h1>
        </div>
    </div>

    <?php if (!empty($message)) { ?> 
        <div class="row justify-content-center">
            <div class="col-6">
                <p class="alert alert-<?php echo $class;?>"><?php echo $message;?></p>
            </div>
        </div>
    <?php } ?>

    <form action="modificar_tarefa.php?id=<?php echo $_GET['id']; ?>" method="post" class="">
        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Nome</label>
            <div class="col-4">
                <input 
                    class="form-control" 
                    type="text" 
                    name="name" 
                    value="<?php echo $tarefa['nome'];?>"
                >
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Descrição</label>
            <div class="col-4">
                <textarea class="form-control" name="descricao" id="" cols="30" rows="10"><?php echo $tarefa['descricao'];?></textarea>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <label for="" class="col-2 text-end fw-bold">Data Execução</label>
            <div class="col-4">
                <input 
                    class="form-control" 
                    type="text" 
                    name="data_execucao" 
                    value="<?php echo $tarefa['data_execucao'];?>"
                >
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col text-center">
                <input  class="btn btn-success btn-large" type="submit" value="Guardar" name="form_b">
            </div>
        </div>
    </form>
</div>


<?php include_once 'partials' . DIRECTORY_SEPARATOR . 'footer.php'; ?>