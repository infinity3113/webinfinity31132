<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['id_plugin'])) {
    $id_plugin = $_POST['id_plugin'];

    $sql = "SELECT nombre FROM plugins WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_plugin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $id_usuario = $_SESSION['user_id'];
        
        // Insertamos la compra en la base de datos
        $sql_compra = "INSERT INTO compras (id_usuario, id_plugin) VALUES (?, ?)";
        $stmt_compra = $conn->prepare($sql_compra);
        $stmt_compra->bind_param("ii", $id_usuario, $id_plugin);

        if ($stmt_compra->execute()) {
            header("Location: panel_usuario.php");
            exit();
        } else {
            die("Hubo un error al registrar tu compra.");
        }
    } else {
        die("Error: El plugin seleccionado no existe.");
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>