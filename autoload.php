<?php

ob_start();

error_reporting(1);

date_default_timezone_set('America/Araguaina');

$expl = explode(DIRECTORY_SEPARATOR, dirname(__FILE__));

$raiz_do_site = $expl[count($expl) - 1];

/**
 * <p>Função para carregar as classes</p>
 * @param type $classname
 */
function TXAutoLoad($classname) {
    global $raiz_do_site;
    //Can't use __DIR__ as it's only in PHP 5.3+
    $_s = DIRECTORY_SEPARATOR;

    //Para incluir alguma classe, é só incluir no final do array o nome da pasta onde ela está encontrada. "$dir_array"
    $dir_array = array(
        'classes'
    );

    foreach ($dir_array as $value) {
        //Insere as classes do sistema
        $filename = dirname(__DIR__) . $_s . $raiz_do_site . $_s . $value . $_s . "class." . strtolower($classname) . '.php';

        if (is_readable($filename)) {
            require $filename;
        }
    }
}

if (version_compare(PHP_VERSION, '5.1.2', '>=')) {
    if (version_compare(PHP_VERSION, '5.3.0', '>=')) {
        spl_autoload_register('TXAutoLoad', true, true);
    } else {
        spl_autoload_register('TXAutoLoad');
    }
} else {

    function __autoload($classname) {
        TXAutoLoad($classname);
    }

}
//Se a sessão não estive iniciada, então inicia-se.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    //session_regenerate_id();
}

include 'config.ini.php';
