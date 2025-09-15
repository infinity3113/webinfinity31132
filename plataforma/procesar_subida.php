<?php
session_start();
require 'db_config.php';

// Función para redirigir con un mensaje de error.
function redirigir_con_error($mensaje) {
    $_SESSION['error_subida'] = $mensaje;
    header("Location: subir_plugin.php");
    exit();
}

// Verificación de seguridad: solo administradores.
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    // Usamos la función para un error genérico si alguien intenta acceder sin permisos.
    redirigir_con_error("Acceso no autorizado.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Validación de datos del formulario.
    $nombre = trim($_POST['nombre']);
    $descripcion_corta = trim($_POST['descripcion_corta']);
    $precio = $_POST['precio'];

    if (empty($nombre) || empty($descripcion_corta) || !is_numeric($precio)) {
        redirigir_con_error("Por favor, completa todos los campos correctamente.");
    }

    // 2. Validación robusta del archivo subido.
    if (!isset($_FILES['plugin_file']) || $_FILES['plugin_file']['error'] != UPLOAD_ERR_OK) {
        $error_code = $_FILES['plugin_file']['error'] ?? UPLOAD_ERR_NO_FILE;
        $mensajes_error = [
            UPLOAD_ERR_INI_SIZE   => "El archivo excede el tamaño máximo permitido por el servidor.",
            UPLOAD_ERR_FORM_SIZE  => "El archivo excede el tamaño máximo permitido en el formulario.",
            UPLOAD_ERR_PARTIAL    => "El archivo se subió solo parcialmente.",
            UPLOAD_ERR_NO_FILE    => "No se seleccionó ningún archivo.",
            UPLOAD_ERR_NO_TMP_DIR => "Error del servidor: no se encontró la carpeta temporal.",
            UPLOAD_ERR_CANT_WRITE => "Error del servidor: no se pudo escribir el archivo en el disco.",
            UPLOAD_ERR_EXTENSION  => "Una extensión de PHP detuvo la subida del archivo.",
        ];
        redirigir_con_error($mensajes_error[$error_code] ?? "Ocurrió un error desconocido durante la subida.");
    }

    // 3. Verificación de seguridad del archivo (MIME Type y extensión).
    $tmp_path = $_FILES['plugin_file']['tmp_name'];
    $nombre_original = basename($_FILES['plugin_file']['name']);
    $extension = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));

    // Verificamos que la extensión sea .jar
    if ($extension !== 'jar') {
        redirigir_con_error("Tipo de archivo no válido. Solo se permiten archivos .jar.");
    }

    // Verificamos el tipo MIME para asegurarnos de que el contenido es coherente.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($tmp_path);
    if ($mime_type !== 'application/java-archive' && $mime_type !== 'application/x-java-archive') {
         redirigir_con_error("El contenido del archivo no parece ser un plugin .jar válido.");
    }

    // 4. Generación de un nombre de archivo único y seguro.
    $nombre_seguro = uniqid('plugin_', true) . '.' . $extension;

    // 5. Mover el archivo a una ubicación segura (fuera del directorio web público).
    // Esta ruta es correcta y segura, ¡bien hecho!
    $directorio_seguro = dirname(__DIR__, 2) . '/archivos_plugins_seguros';
    if (!is_dir($directorio_seguro)) {
        if (!mkdir($directorio_seguro, 0755, true)) {
            redirigir_con_error("Error crítico: no se pudo crear el directorio de almacenamiento.");
        }
    }
    $ruta_destino_segura = $directorio_seguro . '/' . $nombre_seguro;

    if (!move_uploaded_file($tmp_path, $ruta_destino_segura)) {
        redirigir_con_error("No se pudo mover el archivo subido. Revisa los permisos de la carpeta del servidor.");
    }

    // 6. Insertar en la base de datos con los nombres original y seguro.
    $sql = "INSERT INTO plugins (nombre, descripcion_corta, precio, nombre_archivo, nombre_seguro, ruta_archivo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // La ruta ahora es solo el nombre seguro, la construiremos al descargar.
        $stmt->bind_param("ssdsss", $nombre, $descripcion_corta, $precio, $nombre_original, $nombre_seguro, $ruta_destino_segura);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "¡Plugin subido exitosamente!";
            header("Location: panel_admin.php");
            exit();
        } else {
            // Si falla, eliminamos el archivo subido para no dejar basura.
            unlink($ruta_destino_segura);
            redirigir_con_error("Error al registrar el plugin en la base de datos: " . $stmt->error);
        }
    } else {
        unlink($ruta_destino_segura);
        redirigir_con_error("Error fatal al preparar la consulta: " . $conn->error);
    }
    $conn->close();
} else {
    // Redirigir si alguien accede al script directamente sin un POST.
    header("Location: subir_plugin.php");
    exit();
}
?>