<?php
session_start();
require 'db_config.php';

// --- INICIO DE LA CORRECCIÓN ---

/**
 * Obtiene una cadena de texto traducida desde el archivo translations.json.
 *
 * @param string $key La clave de la traducción que se desea obtener.
 * @return string La cadena traducida o la clave si no se encuentra.
 */
function get_translation($key) {
    // Ruta al archivo de traducciones. __DIR__ asegura que la ruta sea siempre correcta.
    $translations_path = __DIR__ . '/translations.json';

    // Comprueba si el archivo de traducciones existe.
    if (!file_exists($translations_path)) {
        // Devuelve un mensaje de error si no se encuentra el archivo.
        return "Error: translations.json not found.";
    }

    // Lee el contenido del archivo JSON.
    $json_content = file_get_contents($translations_path);
    // Decodifica el JSON en un array asociativo de PHP.
    $translations = json_decode($json_content, true);

    // Comprueba si hubo un error al decodificar el JSON.
    if (json_last_error() !== JSON_ERROR_NONE) {
        return "Error: Could not decode translations.json.";
    }

    // Determina el idioma actual de la sesión, usando 'es' (español) como valor por defecto.
    $lang = $_SESSION['lang'] ?? 'es';

    // Devuelve la traducción correspondiente si existe; de lo contrario, devuelve la clave original.
    return $translations[$lang][$key] ?? $key;
}

// --- FIN DE LA CORRECCIÓN ---


// 1. Validaciones iniciales de seguridad y de entrada.
if (!isset($_SESSION['user_id'])) {
    http_response_code(403); // Forbidden
    // Se utiliza la nueva función para obtener el mensaje de error traducido.
    die(get_translation('error_download_no_login'));
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400); // Bad Request
    die(get_translation('error_download_invalid_request'));
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
    die(get_translation('error_download_prepare_query'));
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

        // Limpiar el buffer de salida para evitar corrupción de archivos.
        ob_clean();
        flush();

        // Leer y enviar el archivo al navegador.
        readfile($ruta_archivo_completa);
        exit();
    } else {
        http_response_code(404); // Not Found
        die(get_translation('error_download_file_not_found'));
    }
} else {
    http_response_code(403); // Forbidden
    die(get_translation('error_download_no_permission'));
}

// Es una buena práctica cerrar las conexiones al final.
$stmt->close();
$conn->close();

?>