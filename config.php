<?php
// Database config
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'user_bd');  
define('DB_PASS', 'passwdbd'); 
define('DB_NAME', 'PaiportArbolado');

// Database conection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Evitar problemas con acentos **
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("ConnectError: " . $conn->connect_error);
}

// Path for Logs
define('LOG_FILE', __DIR__ . '/logs/acciones.log');

// Functions
function registerAction($action, $user) {
    $logEntry = date('[Y-m-d H\:i\:s]') . " - $user: $action\n";
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND);
}
?>
