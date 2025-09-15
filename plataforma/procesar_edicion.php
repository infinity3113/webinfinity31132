<?php
session_start();
require 'db_config.php';

// Verificación de seguridad
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Validación de datos del formulario
    if (!isset($_POST['id_plugin'], $_POST['nombre'], $_POST['descripcion_corta'], $_POST['precio'])) {
        $_SESSION['error_message'] = "Faltan datos en el formulario.";
        header("Location: panel_admin.php");
        exit();
    }

    $id_plugin = $_POST['id_plugin'];
    $nombre = trim($_POST['nombre']);
    $descripcion_corta = trim($_POST['descripcion_corta']);
    $precio = $_POST['precio'];

    if (empty($nombre) || empty($descripcion_corta) || !is_numeric($precio) || !is_numeric($id_plugin)) {
        $_SESSION['error_message'] = "Por favor, completa todos los campos correctamente.";
        // Redirige de vuelta a la página de edición si hay un error
        header("Location: editar_plugin.php?id=" . $id_plugin);
        exit();
    }

    // 2. Actualizar en la base de datos
    $stmt = $conn->prepare("UPDATE plugins SET nombre = ?, descripcion_corta = ?, precio = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $nombre, $descripcion_corta, $precio, $id_plugin);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "¡Plugin actualizado exitosamente!";
    } else {
        $_SESSION['error_message'] = "Error al actualizar el plugin: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: panel_admin.php");
    exit();

} else {
    // Redirigir si se accede al script sin un POST
    header("Location: panel_admin.php");
    exit();
}
?>