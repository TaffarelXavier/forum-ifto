<?php

include '../autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $Login = new Login($connection);
    $username = val_input::sani_string('username');
    $password = val_input::sani_string('password');

    $result = $Login->fazer_login($username, $password);

    switch ($result) {
        case (int) 1:
            echo '1';
            break;
        case (int) 0:
            echo '0';
            break;
        case (int) -1:
            echo '-1';
            break;
    }
}