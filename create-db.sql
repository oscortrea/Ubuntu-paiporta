-- create-db.sql: esquema de PaiportArbolado.
-- El usuario de la aplicación (user_bd) y sus permisos NO se crean aquí:
-- los crea OpenTofu/cloud-init solo para la IP del frontend, y la contraseña
-- no debe estar nunca en un repositorio público.

-- 1. Base de datos
CREATE DATABASE IF NOT EXISTS PaiportArbolado CHARACTER SET utf8mb4;
USE PaiportArbolado;

-- 2. Tabla de Árboles (incluye el campo 'imagen' para las fotos)
CREATE TABLE IF NOT EXISTS arboles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    especie VARCHAR(50) NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    fecha_plantacion DATE,
    estado ENUM('sano', 'enfermo', 'talado') DEFAULT 'sano',
    usuario_registro VARCHAR(50),
    imagen VARCHAR(255) DEFAULT NULL
);

-- 3. Tabla de Usuarios (autenticación)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Usuario admin inicial (si ya existe, NO se le cambia la contraseña)
INSERT INTO users (username, password)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE username = username;
