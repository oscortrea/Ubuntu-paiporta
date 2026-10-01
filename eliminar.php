<?php
require_once 'config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit();
}

// Obtener usuario (simulado)
$usuario = "admin";

// Eliminar
$sql = "DELETE FROM arboles WHERE id = $id";
if ($conn->query($sql)) {
    registerAction("Tree Deleted: ID $id", $usuario);
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}
?>
