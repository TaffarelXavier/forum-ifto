<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../autoload.php';

    $acao = val_input::sani_string('acao');

    $msg_tipo = val_input::sani_string('msg_tipo');

    $discussao_fkid = val_input::sani_string('discussao_fkid');

    $edit_imagem = $_POST['edit_imagem'];

    $mensagens = $_POST['mensagens'];

    $user_id = val_input::val_int('user_id');

    if ($user_id === USER_ID) {
        //Instância da classe:
        $msg = new Mensagens($connection);
        switch ($acao) {
            case 'inserir':
                echo $msg->salvarDados(trim($mensagens), time(), USER_ID, $msg_tipo, $edit_imagem, $discussao_fkid) > 0 ? '1' : '0';
                break;
            case 'excluir':
                $id = val_input::val_int('id');
                echo $msg->excluir_por_id($id) > 0 ? '1' : '0';
                break;
        }
    } else {
        echo "ERROR_NOT_RESOLVED";
    }
}
