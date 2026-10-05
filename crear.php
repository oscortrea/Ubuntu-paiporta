<?php
// Requisito técnico y de modularización: Carga centralizada de la BD, rutas y logs
require_once 'config.php';

// Control de flujo CRUD (Create): Procesamiento del formulario al enviar por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Requisito de seguridad: Validación y limpieza contra Inyección SQL (SQL Injection)
    $especie = $conn->real_escape_string($_POST['especie']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
    $fecha = $_POST['fecha_plantacion'];
    $usuario = $conn->real_escape_string($_POST['usuario']);

    // Modificación solicitada: Lógica para la subida de imágenes de los árboles
    $nombre_imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorio_destino = 'uploads/'; // Directorio de destino obligatorio según la práctica
        
        // Control de infraestructura: Crear el directorio uploads automáticamente si no existe
        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0775, true);
        }

        // Modificación solicitada: Renombrar el archivo con timestamp para evitar colisiones
        $nombre_original = basename($_FILES['imagen']['name']);
        $nombre_imagen = time() . '_' . $nombre_original;
        $ruta_completa = $directorio_destino . $nombre_imagen;

        // Movimiento del fichero temporal al directorio definitivo del servidor
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)) {
            $nombre_imagen = null;
        }
    }

    // Preparación del campo imagen para la inserción SQL (permite valor NULL si no se adjunta)
    $imagen_sql = $nombre_imagen ? "'$nombre_imagen'" : "NULL";

    // Operación SQL (Create): Inserción del nuevo registro incluyendo la ruta de la imagen
    $sql = "INSERT INTO arboles (especie, ubicacion, fecha_plantacion, usuario_registro, imagen) 
            VALORES ('$especie', '$ubicacion', '$fecha', '$usuario', $imagen_sql)";

    if ($conn->query($sql)) {
        // Requisito obligatorio: Registro de la acción en el archivo de logs del sistema
        registerAction("Tree added $especie in $ubicacion", $usuario);
        
        // Redirección post-creación hacia la vista principal del CRUD (Read)
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PaiportArbolado: Añadir Árbol</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Añadir Nuevo Árbol</h1>
    <!-- Requisito técnico: Formulario POST que soporta envío de ficheros binarios (enctype) -->
    <form method="POST" enctype="multipart/form-data">
        <label>Especie:</label>
        <input type="text" name="especie" required><br>

        <label>Ubicación:</label>
        <input type="text" name="ubicacion" required><br>

        <label>Fecha de Plantación:</label>
        <input type="date" name="fecha_plantacion" required><br>

        <label>Usuario:</label>
        <input type="text" name="usuario" required><br>

        <!-- Modificación: Selector de archivos tipo input file para la imagen del árbol -->
        <label>Imagen del árbol:</label>
        <input type="file" name="imagen" accept="image/*"><br>

        <button type="submit">Guardar</button>
    </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>
