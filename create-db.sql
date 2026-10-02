-- 1. Limpieza y creación de usuario
DROP USER IF EXISTS 'user_bd'@'localhost';
DROP USER IF EXISTS 'user_bd'@'127.0.0.1';
DROP USER IF EXISTS 'user_bd'@'%';

CREATE USER 'user_bd'@'127.0.0.1' IDENTIFIED BY 'passwdbd';
CREATE USER 'user_bd'@'localhost' IDENTIFIED BY 'passwdbd';

-- 2. Creación de la base de datos y asignación de permisos
CREATE DATABASE IF NOT EXISTS PaiportArbolado;

GRANT ALL PRIVILEGES ON PaiportArbolado.* TO 'user_bd'@'127.0.0.1';
GRANT ALL PRIVILEGES ON PaiportArbolado.* TO 'user_bd'@'localhost';
FLUSH PRIVILEGES;

-- 3. Seleccionar la base de datos para crear las tablas
USE PaiportArbolado;

-- 4. Tabla de Árboles (incluyendo el campo 'imagen' para las fotos)
CREATE TABLE IF NOT EXISTS arboles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    especie VARCHAR(50) NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    fecha_plantacion DATE,
    estado ENUM('sano', 'enfermo', 'talado') DEFAULT 'sano',
    usuario_registro VARCHAR(50),
    imagen VARCHAR(255) DEFAULT NULL
);

-- 5. Tabla de Usuarios (para la autenticación)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);