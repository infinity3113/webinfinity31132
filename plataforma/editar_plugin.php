<?php
$page_title = "Editar Plugin";
require 'plantilla_header.php';

// Verificación de seguridad
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}

require 'db_config.php';

// Validar que se haya proporcionado un ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_message'] = "ID de plugin no válido.";
    header("Location: panel_admin.php");
    exit();
}

$id_plugin = $_GET['id'];
$plugin = null;

// Obtener los datos actuales del plugin
$stmt = $conn->prepare("SELECT nombre, descripcion_corta, precio FROM plugins WHERE id = ?");
$stmt->bind_param("i", $id_plugin);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 1) {
    $plugin = $result->fetch_assoc();
} else {
    $_SESSION['error_message'] = "No se encontró el plugin para editar.";
    header("Location: panel_admin.php");
    exit();
}
$stmt->close();
$conn->close();
?>

<div class="flex items-center justify-center py-12">
    <div class="max-w-lg w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-text-primary">
                Editando el Plugin: <span class="gradient-text"><?php echo htmlspecialchars($plugin['nombre']); ?></span>
            </h2>
        </div>
        
        <form class="mt-8 space-y-6 glass-card p-8 rounded-2xl" action="procesar_edicion.php" method="POST">
             <input type="hidden" name="id_plugin" value="<?php echo $id_plugin; ?>">
             <div class="space-y-4">
                <div>
                    <label for="nombre" class="text-sm font-medium text-text-secondary">Nombre del Plugin</label>
                    <input id="nombre" name="nombre" type="text" required class="mt-1 appearance-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary sm:text-sm" value="<?php echo htmlspecialchars($plugin['nombre']); ?>">
                </div>
                 <div>
                    <label for="descripcion_corta" class="text-sm font-medium text-text-secondary">Descripción Corta</label>
                    <textarea id="descripcion_corta" name="descripcion_corta" rows="3" required class="mt-1 appearance-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary sm:text-sm"><?php echo htmlspecialchars($plugin['descripcion_corta']); ?></textarea>
                </div>
                <div>
                    <label for="precio" class="text-sm font-medium text-text-secondary">Precio (USD)</label>
                    <input id="precio" name="precio" type="number" step="0.01" required class="mt-1 appearance-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary sm:text-sm" value="<?php echo htmlspecialchars($plugin['precio']); ?>">
                </div>
            </div>
            
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-bg-primary bg-accent-primary hover:bg-accent-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-secondary transition-colors">
                Guardar Cambios
            </button>
            <p class="text-center text-sm">
                <a href="panel_admin.php" class="font-medium text-accent-primary hover:text-accent-secondary">Cancelar y volver al panel</a>
            </p>
        </form>
    </div>
</div>

<?php require 'plantilla_footer.php'; ?>