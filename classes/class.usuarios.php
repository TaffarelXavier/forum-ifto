<?php

class Usuarios {

    private $conexao = null;
    private $table_name = 'usuarios';

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

    public function getDataFromUsers($username) {
        try {
            $sth = $this->conexao->prepare('SELECT * FROM `' . $this->table_name . '` WHERE usu_username = ? OR usu_id = ? LIMIT 1');

            $sth->bindValue(1, $username, PDO::PARAM_STR);

            $sth->bindValue(2, $username, PDO::PARAM_STR);

            $sth->execute();

            $count = (int) $sth->rowCount();

            if ($count > 0) {
                $obj = $sth->fetch(PDO::FETCH_OBJ);
                return $obj;
            }
            return (int) -1;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function getNameFromUser($username) {
        try {
            $sth = $this->conexao->prepare('SELECT * FROM `' . $this->table_name . '` WHERE usu_username = ? OR usu_id = ? LIMIT 1;');

            $sth->bindValue(1, $username, PDO::PARAM_STR);

            $sth->bindValue(2, $username, PDO::PARAM_STR);

            $sth->execute();

            $count = (int) $sth->rowCount();
            if ($count > 0) {
                $obj = $sth->fetch(PDO::FETCH_OBJ);
                return $obj;
            }
            return (int) -1;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    /**
     * 
     * @param type $username
     * @param type $password
     * @param type $usu_acesso
     * @return type
     */
    public function salvarDados($username, $password, $usu_acesso) {
        try {

            $sql = 'INSERT INTO ' . $this->table_name . '(`usu_id`,`usu_username`,'
                    . '`usu_password`,`usu_acesso`)VALUES(NULL,?,?,?)';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $username, PDO::PARAM_INT);
            $sth->bindParam(2, $password, PDO::PARAM_STR);
            $sth->bindParam(3, $usu_acesso, PDO::PARAM_STR);
            $sth->execute();
            return $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }
    
    /**
     * 
     * @param type $username
     * @param type $password
     * @param type $usu_acesso
     * @param type $user_id
     * @return type
     */
    public function atualizarDados($username, $password, $usu_acesso, $user_id) {
        try {

            $sql = 'UPDATE `usuarios` SET `usu_username` = ?, `usu_password` = ?, `usu_acesso`=? WHERE `usuarios`.`usu_id` = ?;';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $username, PDO::PARAM_INT);
            $sth->bindParam(2, $password, PDO::PARAM_STR);
            $sth->bindParam(3, $usu_acesso, PDO::PARAM_STR);
            $sth->bindParam(4, $user_id, PDO::PARAM_INT);
            $sth->execute();
            return $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function excluir_por_id($id) {
        try {

            $sql = 'DELETE FROM ' . $this->table_name . ' WHERE usu_id = ?;';
            $sth = $this->conexao->prepare($sql);
            $sth->bindParam(1, $id, PDO::PARAM_INT);
            $sth->execute();
            return (int) $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
