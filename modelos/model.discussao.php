<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../autoload.php';

    $acao = val_input::sani_string('acao');

    $titulo = val_input::sani_string('titulo');
    $descricao = val_input::sani_string('descricao');
    $data = val_input::sani_string('data');
    $usuario_kf_id = val_input::sani_string('usuario_kf_id');

    //Instância da classe:
    $discussao = new Discussao($connection);
    switch ($acao) {
        case 'inserir':
            echo $discussao->salvarDados($titulo, $descricao, $data, $usuario_kf_id) > 0 ? '1' : '0';
            break;
        case 'excluir':
            $id = val_input::val_int('id');
            echo $discussao->excluir_por_id($id) > 0 ? '1' : '0';
            break;
    }
}
