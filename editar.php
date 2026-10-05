<?php
require_once 'config.php';

// Control de sesión: Validar que el usuario se ha autenticado
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
$usuario = $_SESSION['usuario'];

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

// Obtener datos del árbol
$sql = "SELECT * FROM arboles WHERE id = $id";
$result = $conn->query($sql);
$arbol = $result->fetch_assoc();

if (!$arbol) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $especie = $conn->real_escape_string($_POST['especie']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
    $fecha = $_POST['fecha_plantacion'];
    $estado = $conn->real_escape_string($_POST['estado']);

    // Mantener la imagen actual por defecto
    $nombre_imagen = $arbol['imagen'];

    // Procesar nueva imagen si se sube una
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $directorio_destino = 'uploads/';
        if (!file_exists($directorio_destino)) {
            mkdir($directorio_destino, 0775, true);
        }

        $nombre_original = basename($_FILES['imagen']['name']);
        $nuevo_nombre = time() . '_' . $nombre_original;
        $ruta_completa = $directorio_destino . $nuevo_nombre;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_completa)) {
            $nombre_imagen = $nuevo_nombre;
        }
    }

    $imagen_sql = $nombre_imagen ? "'$nombre_imagen'" : "NULL";

    $sql = "UPDATE arboles SET
    especie = '$especie',
    ubicacion = '$ubicacion',
    fecha_plantacion = '$fecha',
    estado = '$estado',
    imagen = $imagen_sql
    WHERE id = $id";

    if ($conn->query($sql)) {
        registerAction("Tree Updated: ID $id", $usuario);
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
    <title>PaiportArbolado : Editar Árbol</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Editar Árbol</h1>
    <p>Editando como: <b><?= htmlspecialchars($usuario) ?></b></p>
    
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $arbol['id'] ?>">

        <label>Especie:</label>
        <input type="text" name="especie" value="<?= htmlspecialchars($arbol['especie']) ?>" required><br>

        <label>Ubicación:</label>
        <input type="text" name="ubicacion" value="<?= htmlspecialchars($arbol['ubicacion']) ?>" required><br>

        <label>Fecha de Plantación:</label>
        <input type="date" name="fecha_plantacion" value="<?= $arbol['fecha_plantacion'] ?>" required><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="sano" <?= $arbol['estado'] === 'sano' ? 'selected' : '' ?>>Sano</option>
            <option value="enfermo" <?= $arbol['estado'] === 'enfermo' ? 'selected' : '' ?>>Enfermo</option>
            <option value="talado" <?= $arbol['estado'] === 'talado' ? 'selected' : '' ?>>Talado</option>
        </select><br>

        <!-- Visualización de la foto actual -->
        <label>Imagen Actual:</label><br>
        <?php if (!empty($arbol['imagen']) && file_exists('uploads/' . $arbol['imagen'])): ?>
            <img src="uploads/<?= htmlspecialchars($arbol['imagen']) ?>" alt="Foto del árbol" style="max-width: 300px; height: auto; border-radius: 8px; margin: 10px 0;"><br>
        <?php else: ?>
            <p><em>Sin imagen registrada</em></p>
        <?php endif; ?>

        <!-- Opción para subir/cambiar la foto -->
        <label>Cambiar Imagen:</label>
        <input type="file" name="imagen" accept="image/*"><br><br>

        <button type="submit">Actualizar</button>
    </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>
