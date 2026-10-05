<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    // Ciframos la contraseña de forma segura tal y como exige la práctica
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql)) {
        echo "¡Usuario registrado con éxito! <a href='login.php'>Ir al login</a>";
        exit();
    } else {
        echo "Error (quizá el usuario ya exista): " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Registro</title><link rel="stylesheet" href="css/style.css"></head>
<body>
    <h1>Crear nuevo usuario</h1>
    <form method="POST">
        <label>Nuevo Usuario:</label>
        <input type="text" name="username" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
