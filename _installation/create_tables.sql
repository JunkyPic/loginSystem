USE login_db;
CREATE TABLE IF NOT EXISTS users_table (login_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, login_username VARCHAR(60) NOT NULL, login_password VARCHAR(100) NOT NULL, login_email VARCHAR(200) NOT NULL) ENGINE = InnoDB;
ALTER TABLE users_table ADD UNIQUE (login_username);
ALTER TABLE users_table ADD UNIQUE (login_email);