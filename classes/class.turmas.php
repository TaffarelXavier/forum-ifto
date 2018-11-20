<?php

class Turmas {

    private $conexao = null;
    private $table_name = 'turmas';

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    public function getDados() {
        try {
            $sth = $this->conexao->prepare('SELECT * FROM ' . $this->table_name);
            $sth->execute();
            return $sth;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function salvarDados($titulo, $descricao, $quant_max, $quant_min) {
        try {

            $sql = 'INSERT INTO ' . $this->table_name . '(`tur_id`,`tur_titulo`,`tur_descricao`,`tur_quant_max`,`tur_quant_min`)VALUES(NULL,?,?,?,?)';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $titulo, PDO::PARAM_INT);
            $sth->bindParam(2, $descricao, PDO::PARAM_STR);
            $sth->bindParam(3, $quant_max, PDO::PARAM_STR);
            $sth->bindParam(4, $quant_min, PDO::PARAM_INT);
            $sth->execute();
            return $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function excluir_por_id($id) {
        try {

            $sql = 'DELETE FROM ' . $this->table_name . ' WHERE tur_id = ?;';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            return (int) $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}