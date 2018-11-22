<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    	include '../autoload.php';

$acao=val_input::sani_string('acao');

	$file_md5 = val_input::sani_string('file_md5');
	$file_real_name = val_input::sani_string('file_real_name');
	$data_criacao = val_input::sani_string('data_criacao');
	$mensagem_fk_id = val_input::sani_string('mensagem_fk_id');
	$usuario_fk_id = val_input::sani_string('usuario_fk_id');

	//Instância da classe:
	$arquivos = new Arquivos($connection);
switch ($acao) {    case 'inserir':
echo $arquivos->salvarDados($file_md5,$file_real_name,$data_criacao,$mensagem_fk_id,$usuario_fk_id) > 0 ? '1':'0';
      break;   case 'excluir':
$id= val_input::val_int('id');
     echo $arquivos->excluir_por_id($id) > 0 ? '1' : '0';      break;}}
