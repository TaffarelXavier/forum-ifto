<?php

class Login {

    private $conexao = null;
    private $table = "usuarios";

    public function __construct($connection) {
        $this->conexao = $connection;
    }

    /**
     * 
     * @param type $user_id
     * @param type $senha
     * @return type
     */
    public function atualizar_senha($user_id, $senha) {
        try {
            $sth = $this->conexao->prepare('UPDATE ' . $this->table . ' SET usu_password = ? WHERE usu_id = ? OR usu_username=?');
            $hash = password_hash($senha, PASSWORD_DEFAULT);
            $sth->bindParam(1, $hash, PDO::PARAM_STR);
            $sth->bindParam(2, $user_id, PDO::PARAM_INT);
            $sth->bindParam(3, $user_id, PDO::PARAM_STR);
            $sth->execute();
            return (int) $sth->rowCount();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * 
     * @param type $username
     * @param type $senha
     * @return type true=sucesso; false=senha incorreta;-1; usuário não encontrado.
     */
    public function fazer_login($username, $senha) {
        try {
            $sth = $this->conexao->prepare('SELECT * FROM `' . $this->table . '` WHERE usu_username = ?');

            $sth->bindValue(1, $username, PDO::PARAM_STR);

            $sth->execute();

            $count = (int) $sth->rowCount();

            if ($count > 0) {
                $obj = $sth->fetch(PDO::FETCH_OBJ);
                if (password_verify($senha, $obj->usu_password)) {
                    $_SESSION['CONECTADO'] = true;
                    $_SESSION['USER_ID'] = (int) $obj->usu_id;
                    return (int) 1;
                } else {
                    return(int) 0;
                }
            }
            return (int) -1;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function insert() {
        try {
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $this->conexao->prepare("INSERT INTO `boletos` (`boleto_id`, `boleto_file_md5`, "
                    . "`boleto_file_realname`, `boleto_cliente_fk_id`, `boleto_pago`) VALUES (NULL,?,?,?,'nao');");
            $stmt->bindParam(1, $file_md5, PDO::PARAM_STR);
            $stmt->bindParam(2, $file_realname, PDO::PARAM_STR);
            $stmt->bindParam(3, $cliente_id, PDO::PARAM_INT);
            $stmt->execute();
            return (int) $stmt->rowCount();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
