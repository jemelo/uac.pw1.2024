<?php

function lerTarefas(string $pesquisa = '', string $estado = ''): array
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

        $tarefa = [
            'id' => trim($tempTarefa[0]),
            'nome' => sanitizar(trim($tempTarefa[1]), true),
            'descricao' => sanitizar(trim($tempTarefa[2]), true),
            'estado' => trim($tempTarefa[3]),
            'utilizador' => trim($tempTarefa[4]),
            'data_criacao' => trim($tempTarefa[5]),
            'data_execucao' => trim($tempTarefa[6]),
        ];

        if (!empty($pesquisa) && (strpos($tarefa['nome'], $pesquisa) === false)) {
            continue;
        }

        if (!empty($estado) && $tarefa['estado'] != $estado) {
            continue;
        }

        $tarefas[] = $tarefa;
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

function sanitizar(string $string, bool $reverter = false): string
{
    if (!$reverter) {
        $substituicoes = [
            "\n" => '<NEWLINEN>',
            "\r" => '<NEWLINER>',
            "<SEP>" => '!!SEP!!'
        ];
    } else {
        $substituicoes = [
            '<NEWLINEN>' => "\n",
            '<NEWLINER>' => "\r",
            '!!SEP!!' => "<SEP>"
        ];
    }
    
    foreach ($substituicoes as $search => $replace) {
    	$string = str_replace($search, $replace, $string);
    }

    return $string;
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
        sanitizar($nome),
        sanitizar($descricao),
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

function obtemTarefa(int $id): array|bool
{
    $tarefas = lerTarefas();
    foreach ($tarefas as $tarefa) {
        if ($tarefa['id'] == $id) {
            return $tarefa;
        }
    }

    return false;
}