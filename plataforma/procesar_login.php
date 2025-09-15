<?php
session_start();
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Se añade is_banned a la consulta
    $sql = "SELECT id, nombre_usuario, password_hash, es_admin, is_banned FROM usuarios WHERE nombre_usuario = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // --- INICIO DE LA CORRECCIÓN ---
            // Verificar si el usuario está baneado ANTES de verificar la contraseña
            if ($user['is_banned'] == 1) {
                $_SESSION['error_message'] = "Tu cuenta ha sido suspendida.";
                header("Location: login.php");
                exit();
            }
            // --- FIN DE LA CORRECCIÓN ---

            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['nombre_usuario'];
                $_SESSION['is_admin'] = $user['es_admin'];
                header("Location: panel_usuario.php");
                exit();
            }
        }
    }
    
    // Si llegamos aquí, hubo un error
    $_SESSION['error_message'] = "Nombre de usuario, email o contraseña incorrectos.";
    header("Location: login.php");
    exit();
}
?>