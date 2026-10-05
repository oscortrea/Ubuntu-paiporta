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
    <!-- Requisito técnico: Enlace a la hoja de estilos estática de la aplicación -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Gestión de Árboles de Paiporta</h1>
    
    <!-- Elemento de sesión: Muestra el usuario actual y permite cerrar sesión -->
    <p>Conectado como: <b><?= htmlspecialchars($_SESSION['usuario']) ?></b> | <a href="logout.php">Cerrar Sesión</a></p>
    
    <!-- Enlace de navegación hacia el formulario de inserción (Create) -->
    <a href="crear.php">Añadir nuevo árbol</a>
    <br><br>
    
    <!-- Funcionalidad solicitada: Campo de búsqueda dinámica integrado con JavaScript -->
    <input type="text" id="buscar" placeholder="Buscar por especie o ubicación..." onkeyup="buscarArboles()">

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Imagen</th> <!-- Ampliación: Columna visual para la imagen del árbol -->
            <th>Especie</th>
            <th>Ubicación</th>
            <th>Fecha Plantación</th>
            <th>Estado</th>
            <th>Acciones</th> <!-- Enlaces para Update y Delete -->
        </tr>
        
        <!-- Bucle de iteración para mostrar todos los registros devueltos (Read) -->
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td>
                <!-- Modificación solicitada: Validación y renderizado de la miniatura de la imagen -->
                <?php if (!empty($row['imagen']) && file_exists('uploads/' . $row['imagen'])): ?>
                    <!-- Requisito de seguridad: htmlspecialchars para prevenir ataques XSS -->
                    <img src="uploads/<?= htmlspecialchars($row['imagen']) ?>" alt="Foto" width="60" style="height: auto; border-radius: 4px;">
                <?php else: ?>
                    <small>Sin imagen</small>
                <?php endif; ?>
            </td>
            <!-- Requisito de seguridad: Limpieza de salida de datos contra XSS -->
            <td><?= htmlspecialchars($row['especie']) ?></td>
            <td><?= htmlspecialchars($row['ubicacion']) ?></td>
            <td><?= $row['fecha_plantacion'] ?></td>
            <td><?= $row['estado'] ?></td>
            <td>
                <!-- Acciones del CRUD: Enlaces de redirección pasando el ID por GET -->
                <a href="editar.php?id=<?= $row['id'] ?>">Editar</a>
                <!-- Control de borrado: Confirmación mediante JavaScript previa a eliminar (Delete) -->
                <a href="eliminar.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este árbol?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Requisito técnico: Carga del script JavaScript para la interactividad de la vista -->
    <script src="js/script.js"></script>
</body>
</html>
<?php 
// Buenas prácticas: Cierre explícito de la conexión a la base de datos al finalizar la página
$conn->close(); 
?>
