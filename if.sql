CREATE TABLE IF NOT EXISTS usuarios(`usu_id` INT NOT NULL AUTO_INCREMENT, `usu_username` VARCHAR(255), `usu_password` VARCHAR(255), PRIMARY KEY (`usu_id`)) ENGINE = InnoDB;
CREATE TABLE IF NOT EXISTS mensagens(`men_id` INT NOT NULL AUTO_INCREMENT, `men_mensagens` VARCHAR(255), `men_data` VARCHAR(255), `men_user_id` INT(11), PRIMARY KEY (`men_id`)) ENGINE = InnoDB;
