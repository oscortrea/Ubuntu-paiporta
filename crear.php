<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $especie = $conn->real_escape_string($_POST['especie']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
    $fecha = $_POST['fecha_plantacion'];
    $usuario = $conn->real_escape_string($_POST['usuario']);

    // Lógica para procesar la subida de la imagen
    $nombre_imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorio_destino = 'uploads/';
        
        // Crear el directorio uploads si no existe
        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0775, true);
        }

        $nombre_original = basename($_FILES['imagen']['name']);
        $nombre_imagen = time() . '_' . $nombre_original;
        $ruta_completa = $directorio_destino . $nombre_imagen;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)) {
            $nombre_imagen = null;
        }
    }

    $imagen_sql = $nombre_imagen ? "'$nombre_imagen'" : "NULL";

    $sql = "INSERT INTO arboles (especie, ubicacion, fecha_plantacion, usuario_registro, imagen) 
            VALUES ('$especie', '$ubicacion', '$fecha', '$usuario', $imagen_sql)";

    if ($conn->query($sql)) {
        registerAction("Tree added $especie in $ubicacion", $usuario);
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
    <form method="POST" enctype="multipart/form-data">
        <label>Especie:</label>
        <input type="text" name="especie" required><br>

        <label>Ubicación:</label>
        <input type="text" name="ubicacion" required><br>

        <label>Fecha de Plantación:</label>
        <input type="date" name="fecha_plantacion" required><br>

        <label>Usuario:</label>
        <input type="text" name="usuario" required><br>

        <label>Imagen del árbol:</label>
        <input type="file" name="imagen" accept="image/*"><br>

        <button type="submit">Guardar</button>
    </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>