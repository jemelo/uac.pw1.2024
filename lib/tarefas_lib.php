<?php

function lerTarefas(): array
{
    if (!file_exists( "data" . DIRECTORY_SEPARATOR . "tarefas.txt")) {
        return [];
    }
    
    // abrir o ficheiro no directorio superior data/utilizadores
    $ftarefas = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "tarefas.txt",
        "r"
    );

    $tarefas = [];
    while(($linha = fgets($ftarefas)) !== false) {
        $tempTarefa = explode("<SEP>", $linha);

        $tarefas[] = [
            'id' => trim($tempTarefa[0]),
            'nome' => trim($tempTarefa[1]),
            'descricao' => trim($tempTarefa[2]),
            'estado' => trim($tempTarefa[3]),
            'utilizador' => trim($tempTarefa[4]),
            'data_criacao' => trim($tempTarefa[5]),
            'data_execucao' => trim($tempTarefa[6]),
        ];
    }

    fclose($ftarefas);
    return $tarefas;
}

function obtemProximoId(): int
{
    $tarefas = lerTarefas();

    if (count($tarefas) == 0) {
        return 1;
    }

    return $tarefas[count($tarefas)-1]['id'] + 1;
}

function adicionarTarefa(string $nome, string $descricao, string $utilizador): array|bool
{
    $id = obtemProximoId();
    
    $ftarefas = fopen(
        "data"
            . DIRECTORY_SEPARATOR
            . "tarefas.txt",
        'a'
    );

    $tarefa = [
        $id,
        $nome,
        $descricao,
        1,
        $utilizador,
        date('Y-m-d H:is'),
        ''
    ];

    $resultado = fputs($ftarefas, implode('<SEP>', $tarefa) . "\n");
    fclose($ftarefas);
    
    if ($resultado === false) {
        return false;
    }

    return $tarefa;
}