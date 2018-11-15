<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../autoload.php';

    $Login = new Login($connection);

    $Usuario = new Usuarios($connection);

    $obj = $Usuario->getDataFromUsers(USER_ID);

    $acao = val_input::sani_string('acao');

    $username = val_input::sani_string('username');
    $password = val_input::sani_string('password');
    $nivel_acesso = val_input::sani_string('nivel_acesso');

    //Instância da classe:
    $usuarios = new Usuarios($connection);
    
    switch ($acao) {
        case 'inserir':
            $hash = password_hash($password, PASSWORD_DEFAULT);
            echo $usuarios->salvarDados($username, $hash, $nivel_acesso) > 0 ? '1' : '0';
            break;
        case 'editar':
            $hash = password_hash($password, PASSWORD_DEFAULT);
            if ($obj->usu_acesso == 'padrao') {
                echo $usuarios->atualizarDados($username, $hash, 'padrao', USER_ID) > 0 ? '1' : '0';
            } else {
                echo $usuarios->atualizarDados($username, $hash, $nivel_acesso, USER_ID) > 0 ? '1' : '0';
            }
            break;
        case 'excluir':
            $id = val_input::val_int('id');
            echo $usuarios->excluir_por_id($id) > 0 ? '1' : '0';
            break;
    }
}
