<?php

class Discussao {

    private $conexao = null;
    private $table_name = 'discussao';

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    public function getDados() {
        try {
            $sth = $this->conexao->prepare('SELECT * FROM ' . $this->table_name. ' ORDER BY dis_id DESC;');
            $sth->execute();
            return $sth;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function salvarDados($titulo, $descricao, $data, $usuario_kf_id) {
        try {

            $sql = 'INSERT INTO ' . $this->table_name . '(`dis_id`,`dis_titulo`,`dis_descricao`,`dis_data`,`dis_usuario_kf_id`)VALUES(NULL,?,?,?,?)';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $titulo, PDO::PARAM_INT);
            $sth->bindParam(2, $descricao, PDO::PARAM_STR);
            $sth->bindParam(3, $data, PDO::PARAM_STR);
            $sth->bindParam(4, $usuario_kf_id, PDO::PARAM_STR);
            $sth->execute();
            return $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function excluir_por_id($id) {
        try {

            $sql = 'DELETE FROM ' . $this->table_name . ' WHERE dis_id = ?;';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            return (int) $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}