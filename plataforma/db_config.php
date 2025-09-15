<?php
// Habilitar errores para depuración local
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- ATENCIÓN: CONFIGURACIÓN PARA XAMPP ---
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Usuario por defecto en XAMPP
define('DB_PASS', '');     // Contraseña vacía por defecto en XAMPP
define('DB_NAME', 'infinity_db'); // El nombre que creaste en phpMyAdmin

// --- NO CAMBIES NADA DEBAJO DE ESTA LÍNEA ---
@$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    $conn = null;
} else {
    $conn->set_charset("utf8mb4");
}
?>