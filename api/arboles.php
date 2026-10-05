<?php
// /var/www/arboles-paiporta/api/arboles.php
header("Content-Type: application/json; charset=UTF-8");

// Incluimos la configuración (ajusta la ruta relativa según donde esté api respecto a config.php)
require_once __DIR__ . '/../config.php';

// Opcional: Permitir peticiones externas si fuera necesario (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

// Consultar todos los árboles
$sql = "SELECT id, especie, ubicacion, fecha_plantacion, estado, imagen FROM arboles";
$result = $conn->query($sql);

$arboles = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $arboles[] = [
            "id" => (int)$row['id'],
            "especie" => $row['especie'],
            "ubicacion" => $row['ubicacion'],
            "fecha_plantacion" => $row['fecha_plantacion'],
            "estado" => $row['estado'],
            "imagen" => !empty($row['imagen']) ? "uploads/" . $row['imagen'] : null
        ];
    }
}

// Devolver respuesta en formato JSON limpio
echo json_encode([
    "status" => "success",
    "total" => count($arboles),
    "data" => $arboles
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$conn->close();
?>
