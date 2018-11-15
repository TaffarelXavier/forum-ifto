<?php

include '../autoload.php';

$msg = new Mensagens($connection);

$Usuario = new Usuarios($connection);

$discussao_id = val_input::val_int('discussao_id');

$ft = $msg->getDados($discussao_id);

$arrar_json = [];

$k = 0;
while ($rows = $ft->fetch(PDO::FETCH_ASSOC)) {
    $k++;
    $user_name = $Usuario->getNameFromUser($rows['men_user_id']);
    $rows['nome'] = $user_name->usu_username;
    $arrar_json[$k] = $rows;
}

echo json_encode($arrar_json);
