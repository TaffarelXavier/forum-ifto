<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../autoload.php';

    $acao = val_input::sani_string('acao');

    $nome = val_input::sani_string('nome');
    $descricao = val_input::sani_string('descricao');
    $quant_max = val_input::sani_string('quant_max');
    $quant_min = val_input::sani_string('quant_min');

    //Instância da classe:
    $turmas = new Turmas($connection);

    switch ($acao) {
        case 'inserir':
            echo $turmas->salvarDados($nome, $descricao, $quant_max, $quant_min) > 0 ? '1' : '0';
            break;
        case 'excluir':
            $id = val_input::val_int('id');
            echo $turmas->excluir_por_id($id) > 0 ? '1' : '0';
            break;
    }
}