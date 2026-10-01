DROP USER IF EXISTS 'user_bd'@'localhost';
DROP USER IF EXISTS 'user_bd'@'127.0.0.1';
DROP USER IF EXISTS 'user_bd'@'%';

CREATE USER 'user_bd'@'127.0.0.1' IDENTIFIED BY 'passwdbd';
CREATE USER 'user_bd'@'localhost' IDENTIFIED BY 'passwdbd';

CREATE DATABASE IF NOT EXISTS PaiportArbolado;
GRANT ALL PRIVILEGES ON PaiportArbolado.* TO 'user_bd'@'127.0.0.1';
FLUSH PRIVILEGES;
