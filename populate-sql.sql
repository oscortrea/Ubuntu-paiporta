USE PaiportArbolado;

CREATE TABLE arboles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    especie VARCHAR(50) NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    fecha_plantacion DATE,
    estado ENUM('sano', 'enfermo', 'talado') DEFAULT 'sano',
    usuario_registro VARCHAR(50),
    imagen VARCHAR(255) DEFAULT NULL
);
