<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_usuario']) && is_numeric($_POST['id_usuario'])) {
    
    $id_usuario = $_POST['id_usuario'];
    $action = $_POST['action'] ?? '';

    if ($action === 'update_status' && isset($_POST['es_admin'], $_POST['is_banned'])) {
        $es_admin = $_POST['es_admin'];
        $is_banned = $_POST['is_banned'];
        
        $stmt = $conn->prepare("UPDATE usuarios SET es_admin = ?, is_banned = ? WHERE id = ?");
        $stmt->bind_param("iii", $es_admin, $is_banned, $id_usuario);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Estado del usuario actualizado correctamente.";
        } else {
            $_SESSION['error_message'] = "Error al actualizar el estado del usuario.";
        }
        $stmt->close();
    } 
    elseif ($action === 'grant_plugin' && isset($_POST['id_plugin'])) {
        $id_plugin = $_POST['id_plugin'];

        // Evitar duplicados
        $stmt_check = $conn->prepare("SELECT id FROM compras WHERE id_usuario = ? AND id_plugin = ?");
        $stmt_check->bind_param("ii", $id_usuario, $id_plugin);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if($result_check->num_rows == 0) {
            $stmt_insert = $conn->prepare("INSERT INTO compras (id_usuario, id_plugin) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $id_usuario, $id_plugin);
            if ($stmt_insert->execute()) {
                $_SESSION['success_message'] = "Plugin otorgado al usuario correctamente.";
            } else {
                $_SESSION['error_message'] = "Error al otorgar el plugin.";
            }
            $stmt_insert->close();
        } else {
             $_SESSION['error_message'] = "El usuario ya posee este plugin.";
        }
        $stmt_check->close();
    }
    else {
        $_SESSION['error_message'] = "Acción no válida.";
    }

    $conn->close();
    header("Location: editar_usuario.php?id=" . $id_usuario);
    exit();
}

header("Location: gestionar_usuarios.php");
exit();
?>