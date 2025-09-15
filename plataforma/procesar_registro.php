<?php
session_start();
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error_message'] = "Todos los campos son obligatorios.";
        header("Location: registro.php");
        exit();
    }
    
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO usuarios (nombre_usuario, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $username, $email, $password_hash);
        
        if ($stmt->execute()) {
            // Iniciar sesión automáticamente después del registro
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = 0; // Por defecto no es admin
            header("Location: panel_usuario.php");
            exit();
        } else {
            if ($conn->errno == 1062) {
                $_SESSION['error_message'] = "El nombre de usuario o el correo electrónico ya existen.";
            } else {
                $_SESSION['error_message'] = "Error al registrar el usuario. Inténtalo de nuevo.";
            }
            header("Location: registro.php");
            exit();
        }
    }
}
?>