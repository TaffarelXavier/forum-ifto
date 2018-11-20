
<?php

$dsn = 'mysql:host=localhost;dbname=evil_db';
$username = 'root';
$password = 'chkdsk';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

$conn = new PDO($dsn, $username, $password, $options);

$stm = $conn->prepare("SELECT * FROM mensagens LIMIT 10;");
$stm->execute();

$array = [];

while ($dados = $stm->fetch(PDO::FETCH_OBJ)) {

    $array[] = array(
        'id' => $dados->men_id,
        'mensagem' => $dados->men_mensagens,
        'data' => $dados->men_data
    );
}
echo json_encode($array);