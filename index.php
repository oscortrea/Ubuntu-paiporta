<?php
// Requisito técnico: Carga centralizada de la conexión a la base de datos y configuraciones
require_once 'config.php';

// Control de sesión: Validar que el usuario se ha autenticado previamente
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Operación CRUD (Read): Consulta SQL para obtener la lista completa de registros de árboles
$sql = "SELECT * FROM arboles";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>PaiportArbolado : Árboles de Paiporta</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Gestión de Árboles de Paiporta</h1>
    
    <p>Conectado como: <b><?= htmlspecialchars($_SESSION['usuario']) ?></b> | <a href="logout.php">Cerrar Sesión</a></p>
    
    <a href="crear.php">Añadir nuevo árbol</a>
    <br><br>
    
    <!-- Input con el evento onkeyup correcto -->
    <input type="text" id="buscar" placeholder="Buscar por especie o ubicación..." onkeyup="buscarArboles()">

    <!-- Añadimos un id="tabla-arboles" para que el JS lo encuentre al instante -->
    <table border="1" id="tabla-arboles">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Especie</th>
                <th>Ubicación</th>
                <th>Fecha Plantación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td>
                    <?php if (!empty($row['imagen']) && file_exists('uploads/' . $row['imagen'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['imagen']) ?>" alt="Foto" width="60" style="height: auto; border-radius: 4px;">
                    <?php else: ?>
                        <small>Sin imagen</small>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($row['especie']) ?></td>
                <td><?= htmlspecialchars($row['ubicacion']) ?></td>
                <td><?= $row['fecha_plantacion'] ?></td>
                <td><?= $row['estado'] ?></td>
                <td>
                    <a href="editar.php?id=<?= $row['id'] ?>">Editar</a>
                    <a href="eliminar.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este árbol?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Carga del script al final del body -->
    <script src="js/script.js"></script>
</body>
</html>
<?php 
$conn->close(); 
?>
