<?php
session_start();
require 'db_config.php';
require 'translations.php'; // Incluir el archivo de traducciones

// 1. Validaciones iniciales de seguridad y de entrada.
if (!isset($_SESSION['user_id'])) {
    http_response_code(403); // Forbidden
    die(get_translation('access_denied_login'));
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400); // Bad Request
    die(get_translation('invalid_request'));
}

$id_plugin = $_GET['id'];
$id_usuario = $_SESSION['user_id'];

// 2. Comprobar si el usuario ha comprado el plugin.
$sql_check = "SELECT p.nombre_archivo, p.nombre_seguro
              FROM compras c
              JOIN plugins p ON c.id_plugin = p.id
              WHERE c.id_usuario = ? AND c.id_plugin = ?";

$stmt = $conn->prepare($sql_check);
if (!$stmt) {
    http_response_code(500); // Internal Server Error
    die(get_translation('prepare_query_error'));
}

$stmt->bind_param("ii", $id_usuario, $id_plugin);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $plugin_data = $result->fetch_assoc();
    $nombre_archivo_publico = $plugin_data['nombre_archivo'];
    $nombre_archivo_seguro = $plugin_data['nombre_seguro'];

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

        ob_clean();
        flush();

        readfile($ruta_archivo_completa);
        exit();
    } else {
        http_response_code(404); // Not Found
        die(get_translation('file_not_found_error'));
    }
} else {
    http_response_code(403); // Forbidden
    die(get_translation('no_permission_download'));
}
?>