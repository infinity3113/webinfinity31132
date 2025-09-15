<?php
session_start();
require 'db_config.php';

// Verificación de seguridad
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

// Validar que se haya proporcionado un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "ID de plugin no válido.";
    header("Location: panel_admin.php");
    exit();
}

$id_plugin = $_GET['id'];

// Opcional pero recomendado: Eliminar el archivo físico del plugin del servidor
$stmt_select = $conn->prepare("SELECT nombre_seguro FROM plugins WHERE id = ?");
$stmt_select->bind_param("i", $id_plugin);
$stmt_select->execute();
$result = $stmt_select->get_result();
if ($result->num_rows === 1) {
    $plugin_data = $result->fetch_assoc();
    $nombre_seguro = $plugin_data['nombre_seguro'];
    $directorio_seguro = dirname(__DIR__, 2) . '/archivos_plugins_seguros';
    $ruta_archivo = $directorio_seguro . '/' . $nombre_seguro;

    if (file_exists($ruta_archivo)) {
        unlink($ruta_archivo); // Elimina el archivo .jar
    }
}
$stmt_select->close();


// Eliminar el registro de la base de datos
$stmt_delete = $conn->prepare("DELETE FROM plugins WHERE id = ?");
$stmt_delete->bind_param("i", $id_plugin);

if ($stmt_delete->execute()) {
    $_SESSION['success_message'] = "Plugin eliminado exitosamente.";
} else {
    $_SESSION['error_message'] = "Error al eliminar el plugin: " . $stmt_delete->error;
}

$stmt_delete->close();
$conn->close();

header("Location: panel_admin.php");
exit();
?>