<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['id_plugin'])) {
    $id_plugin = $_POST['id_plugin'];

    // --- INICIO DE LA MODIFICACIÓN ---
    // 1. Verificar el precio del plugin antes de procesar la compra.
    $sql_check_price = "SELECT precio FROM plugins WHERE id = ?";
    $stmt_check_price = $conn->prepare($sql_check_price);
    $stmt_check_price->bind_param("i", $id_plugin);
    $stmt_check_price->execute();
    $result_price = $stmt_check_price->get_result();

    if ($result_price->num_rows == 1) {
        $plugin = $result_price->fetch_assoc();

        // 2. Si el plugin tiene un precio mayor a 0, detener la ejecución.
        if ($plugin['precio'] > 0) {
            die("Las compras para plugins pagos no están habilitadas en este momento. Por favor, contacta a infinity3113 en Discord para más información.");
        }

        // 3. Si el plugin es gratis (precio = 0), proceder con la lógica existente.
        $id_usuario = $_SESSION['user_id'];
        
        // Insertamos la "compra" (reclamación) en la base de datos
        $sql_compra = "INSERT INTO compras (id_usuario, id_plugin) VALUES (?, ?)";
        $stmt_compra = $conn->prepare($sql_compra);
        $stmt_compra->bind_param("ii", $id_usuario, $id_plugin);

        if ($stmt_compra->execute()) {
            header("Location: panel_usuario.php");
            exit();
        } else {
            // Manejar el caso de que el usuario ya lo haya reclamado (error de clave única)
            if ($conn->errno == 1062) {
                 header("Location: panel_usuario.php"); // Si ya lo tiene, simplemente redirigir a su panel.
                 exit();
            }
            die("Hubo un error al registrar tu reclamación.");
        }
    } else {
        die("Error: El plugin seleccionado no existe.");
    }
    // --- FIN DE LA MODIFICACIÓN ---

} else {
    header("Location: ../index.php");
    exit();
}
?>