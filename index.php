<?php
require_once 'config.php';

// Consultar árboles
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
    <a href="crear.php">Añadir nuevo árbol</a>
    <input type="text" id="buscar" placeholder="Buscar por especie o ubicación..." onkeyup="buscarArboles()">

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Imagen</th>
            <th>Especie</th>
            <th>Ubicación</th>
            <th>Fecha Plantación</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
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
    </table>

    <script src="js/script.js"></script>
</body>
</html>
<?php $conn->close(); ?>