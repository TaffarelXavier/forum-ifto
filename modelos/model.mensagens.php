<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include '../autoload.php';

    $acao = val_input::sani_string('acao');

    $msg_tipo = val_input::sani_string('msg_tipo');

    $discussao_fkid = val_input::sani_string('discussao_fkid');

    $upload_imagem = val_input::sani_string('upload_imagem');

    $edit_imagem = $_POST['edit_imagem'];

    $mensagens = $_POST['mensagens'];

    $user_id = val_input::val_int('user_id');

    if ($user_id === USER_ID) {
        //Instância da classe:
        $msg = new Mensagens($connection);

        switch ($acao) {
            case 'inserir':

                echo $msg->salvarDados(trim($mensagens), time(), USER_ID, $msg_tipo, $edit_imagem, $discussao_fkid) > 0 ? '1' : '0';
                //
                if (is_string($upload_imagem) && strcmp($upload_imagem, "true") === 0) {

                    define('UPLOAD_DIR', '../uploads/');

                    $values = array_keys($_POST['imagens']);

                    for ($i = 0; $i < count($values); $i++) {

                        $img = str_replace('data:image/tmp;base64,', '', $_POST['imagens'][$i]);

                        $img = str_replace(' ', '+', $img);

                        $data = base64_decode($img);

                        $better_token = md5(uniqid(rand(), true));

                        $file = $better_token . '.png';

                        $success = file_put_contents(UPLOAD_DIR . $file, $data);

                        $Arq = new Arquivos($connection);

                        $Arq->salvarDados($file, $_POST['nomes_files'][$i], time(), $msg->get_lasta_id(), USER_ID);
                    }
                }
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
