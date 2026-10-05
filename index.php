<?php
// Requisito técnico: Carga centralizada de la conexión a la base de datos y configuraciones
require_once 'config.php';

// Control de sesión: Validar que el usuario se ha autenticado previamente
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Operación CRUD (Read): Consulta SQL completa para obtener los registros
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
    <a href="crear.php">Añadir nuevo árbol</a>
    <a href="dashboard.php" style="background-color: #059669; margin-left: 10px;">Ver Dashboard Estadísticas</a>
    <br><br>
    
    <!-- Input de búsqueda simple y directo -->
    <input type="text" id="buscador" placeholder="Escribe para filtrar por especie o ubicación..." onkeyup="filtrarTabla()" style="width: 100%; max-width: 400px; padding: 10px; margin-bottom: 20px;">

    <table border="1" id="tablaArboles">
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
            <?php if ($result && $result->num_rows > 0): ?>
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
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No hay árboles registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Script embebido directamente: sin problemas de rutas externas ni caché -->
    <script>
    function filtrarTabla() {
        const input = document.getElementById('buscador');
        const filtro = input.value.toLowerCase();
        const tabla = document.getElementById('tablaArboles');
        const filas = tabla.getElementsByTagName('tr');

        // Empezamos desde i = 1 para saltar la cabecera (th)
        for (let i = 1; i < filas.length; i++) {
            const fila = filas[i];
            const celdas = fila.getElementsByTagName('td');
            
            if (celdas.length > 0) {
                // Obtenemos el texto de la Especie (columna 2) y Ubicación (columna 3)
                const especie = celdas[2].textContent.toLowerCase();
                const ubicacion = celdas[3].textContent.toLowerCase();

                // Si lo que escribimos coincide con la especie o la ubicación, mostramos la fila; si no, la ocultamos
                if (especie.includes(filtro) || ubicacion.includes(filtro)) {
                    fila.style.display = "";
                } else {
                    fila.style.display = "none";
                }
            }
        }
    }
    </script>
</body>
</html>
<?php 
$conn->close(); 
?>
