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

// 1. Obtener la imagen asociada para borrar el archivo físico del servidor (evitar basura)
$sql_img = "SELECT imagen FROM arboles WHERE id = $id";
$res_img = $conn->query($sql_img);
if ($res_img && $row = $res_img->fetch_assoc()) {
    if (!empty($row['imagen']) && file_exists('uploads/' . $row['imagen'])) {
        unlink('uploads/' . $row['imagen']);
    }
}

// 2. Eliminar el registro de la base de datos
$sql = "DELETE FROM arboles WHERE id = $id";
if ($conn->query($sql)) {
    registerAction("Tree Deleted: ID $id", $usuario);
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
