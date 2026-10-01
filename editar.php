<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

// Obtener datos del árbol
$sql = "SELECT * FROM arboles WHERE id = $id";
$result = $conn->query($sql);
$arbol = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $especie = $conn->real_escape_string($_POST['especie']);
    $ubicacion = $conn->real_escape_string($_POST['ubicacion']);
    $fecha = $_POST['fecha_plantacion'];
    $estado = $conn->real_escape_string($_POST['estado']);
    $usuario = $conn->real_escape_string($_POST['usuario']);

    $sql = "UPDATE arboles SET
    especie = '$especie',
    ubicacion = '$ubicacion',
    fecha_plantacion = '$fecha',
    estado = '$estado'
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
    <form method="POST">
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

        <label>Usuario:</label>
        <input type="text" name="usuario" value="<?= htmlspecialchars($arbol['usuario_registro']) ?>" required><br>

        <button type="submit">Actualizar</button>
        </form>
    <a href="index.php">Volver a la lista</a>
</body>
</html>
