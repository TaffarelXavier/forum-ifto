<?php
include '../autoload.php';
session_destroy();
unset($_SESSION['CONECTADO']);
unset($_SESSION['USER_ID']);