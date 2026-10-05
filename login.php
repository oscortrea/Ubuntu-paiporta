<?php
require_once 'config.php';
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verifica la contraseña con hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario'] = $user['username'];
            registerAction("Inicio de sesión exitoso", $user['username']);
            header("Location: index.php");
            exit();
        }
    }
    $error = "Usuario o contraseña incorrectos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - PaiportArbolado</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Iniciar Sesión - PaiportArbolado</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Usuario:</label>
        <input type="text" name="username" required><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Entrar</button>
    </form>
    <p><small>Credenciales por defecto -> Usuario: <b>admin</b> | Contraseña: <b>1234</b></small></p>
</body>
</html>