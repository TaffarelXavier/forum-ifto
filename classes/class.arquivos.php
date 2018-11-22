<?php

class Arquivos {

    private $conexao = null;
    private $table_name = 'arquivos';

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    public function get_imagens_from_fk_id($msg_kf_id) {
        try {
            $sth = $this->conexao->prepare('SELECT arq_id, arq_file_md5 FROM ' . $this->table_name . ' WHERE arq_mensagem_fk_id = ?');
            $sth->bindParam(1, $msg_kf_id, PDO::PARAM_INT);
            $sth->execute();
           return $sth;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $file_md5
     * @param type $file_real_name
     * @param type $data_criacao
     * @param type $mensagem_fk_id
     * @param type $usuario_fk_id
     * @return type
     */
    public function salvarDados($file_md5, $file_real_name, $data_criacao, $mensagem_fk_id, $usuario_fk_id) {
        try {

            $sql = 'INSERT INTO ' . $this->table_name . '(`arq_id`,`arq_file_md5`,`arq_file_real_name`,`arq_data_criacao`,`arq_mensagem_fk_id`,`arq_usuario_fk_id`)VALUES(NULL,?,?,?,?,?)';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $file_md5, PDO::PARAM_INT);
            $sth->bindParam(2, $file_real_name, PDO::PARAM_STR);
            $sth->bindParam(3, $data_criacao, PDO::PARAM_STR);
            $sth->bindParam(4, $mensagem_fk_id, PDO::PARAM_STR);
            $sth->bindParam(5, $usuario_fk_id, PDO::PARAM_STR);
            $sth->execute();
            return $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function excluir_por_id($id) {
        try {

            $sql = 'DELETE FROM ' . $this->table_name . ' WHERE arq_id = ?;';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            return (int) $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
