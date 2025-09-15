<?php
session_start();
require 'db_config.php';

// 1. Validaciones iniciales de seguridad y de entrada.
if (!isset($_SESSION['user_id'])) {
    http_response_code(403); // Forbidden
    die("Acceso denegado. Debes iniciar sesión.");
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400); // Bad Request
    die("Solicitud no válida.");
}

$id_plugin = $_GET['id'];
$id_usuario = $_SESSION['user_id'];

// 2. Comprobar si el usuario ha comprado el plugin.
// La consulta ahora obtiene el nombre_seguro para buscar el archivo.
$sql_check = "SELECT p.nombre_archivo, p.nombre_seguro
              FROM compras c
              JOIN plugins p ON c.id_plugin = p.id
              WHERE c.id_usuario = ? AND c.id_plugin = ?";

$stmt = $conn->prepare($sql_check);
if (!$stmt) {
    http_response_code(500); // Internal Server Error
    die("Error al preparar la consulta.");
}

$stmt->bind_param("ii", $id_usuario, $id_plugin);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $plugin_data = $result->fetch_assoc();
    $nombre_archivo_publico = $plugin_data['nombre_archivo']; // El nombre que verá el usuario.
    $nombre_archivo_seguro = $plugin_data['nombre_seguro'];   // El nombre real en el servidor.

    // 3. Construir la ruta segura y verificar que el archivo existe.
    $directorio_seguro = dirname(__DIR__, 2) . '/archivos_plugins_seguros';
    $ruta_archivo_completa = $directorio_seguro . '/' . $nombre_archivo_seguro;

    if (file_exists($ruta_archivo_completa)) {
        // 4. Forzar la descarga del archivo de forma segura.
        header('Content-Description: File Transfer');
        header('Content-Type: application/java-archive');
        header('Content-Disposition: attachment; filename="' . htmlspecialchars($nombre_archivo_publico) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($ruta_archivo_completa));

        // Limpiar el buffer de salida para evitar corrupción de archivos.
        ob_clean();
        flush();

        // Leer el archivo y enviarlo al navegador.
        readfile($ruta_archivo_completa);
        exit();
    } else {
        http_response_code(404); // Not Found
        die("Error crítico: El archivo del plugin no se encuentra en el servidor. Por favor, contacta al administrador.");
    }
} else {
    http_response_code(403); // Forbidden
    die("No tienes permiso para descargar este archivo. Asegúrate de haberlo comprado.");
}
?>