<?php

class Mensagens {

    private $conexao = null;
    private $table_name = 'mensagens';

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    /**
     * 
     * @param type $discussao_kfid
     * @return type
     */
    public function getDados($discussao_kfid) {
        try {
            $sth = $this->conexao->prepare('SELECT * FROM ' .
                    $this->table_name . ' WHERE men_discussao_fk_id = ?');
            $sth->bindParam(1, $discussao_kfid, PDO::PARAM_INT);
            $sth->execute();
            return $sth;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    public function get_arquivos_from_mensagem_id($discussao_kfid) {
        try {
            $sth = $this->conexao->prepare('SELECT * FROM ' .
                    $this->table_name . ' WHERE men_discussao_fk_id = ?');
            $sth->bindParam(1, $discussao_kfid, PDO::PARAM_INT);
            $sth->execute();
            return $sth;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function get_lasta_id() {
        try {
            $sth = $this->conexao->prepare('SELECT men_id FROM ' .
                    $this->table_name . ' ORDER BY men_id DESC LIMIT 1');
             $sth->execute();
             $data = $sth->fetch(PDO::FETCH_OBJ);
            return (int) $data->men_id;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $mensagens
     * @param type $data
     * @param type $user_id
     * @param type $tipo
     * @param type $image
     * @param type $discussao_fk_id
     * @return type
     */
    public function salvarDados($mensagens, $data, $user_id, $tipo, $image, $discussao_fk_id) {
        try {

            $sql = 'INSERT INTO ' . $this->table_name . '(`men_id`,`men_mensagens`,`men_data`,'
                    . '`men_user_id`,`men_tipo`,`men_image`,`men_discussao_fk_id`)VALUES(NULL,?,?,?,?,?,?)';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $mensagens, PDO::PARAM_INT);
            $sth->bindParam(2, $data, PDO::PARAM_STR);
            $sth->bindParam(3, $user_id, PDO::PARAM_STR);
            $sth->bindParam(4, $tipo, PDO::PARAM_STR);
            $sth->bindParam(5, $image, PDO::PARAM_LOB);
            $sth->bindParam(6, $discussao_fk_id, PDO::PARAM_INT);
            $sth->execute();
            return $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function excluir_por_id($id) {
        try {

            $sql = 'DELETE FROM ' . $this->table_name . ' WHERE men_id = ?;';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            return (int) $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
