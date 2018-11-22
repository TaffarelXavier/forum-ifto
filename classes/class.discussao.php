<?php

class Discussao {

    private $conexao = null;
    private $table_name = 'discussao';

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    public function getDados() {
        try {
            $sth = $this->conexao->prepare('SELECT * FROM ' . $this->table_name . ' ORDER BY dis_id DESC;');
            $sth->execute();
            return $sth;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $discussao_id
     * @return type
     */
    public function is_discussao_existe($discussao_id) {
        try {
            $sth = $this->conexao->prepare('SELECT COUNT(*) as count_total FROM `' . $this->table_name . '` WHERE dis_id = ?;');
            $sth->bindParam(1, $discussao_id, PDO::PARAM_INT);
            $sth->execute();
            $info = $sth->fetch(PDO::FETCH_OBJ);
            return (int) $info->count_total;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $discussao_id
     * @return type
     */
    public function get_discussao_por_id($discussao_id) {
        try {
            $sth = $this->conexao->prepare('SELECT dis_id,dis_titulo,dis_descricao,dis_data, '
                    . 'dis_usuario_kf_id, dis_disponibilidade, dis_mensagem_fixa, usu_id, usu_username FROM `' . $this->table_name . '`'
                    . ' as t1 JOIN usuarios as t2 ON t1.dis_usuario_kf_id = t2.usu_id WHERE t1.dis_id = ?;');
            $sth->bindParam(1, $discussao_id, PDO::PARAM_INT);
            $sth->execute();
            $info = $sth->fetch(PDO::FETCH_OBJ);
            return $info;
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
