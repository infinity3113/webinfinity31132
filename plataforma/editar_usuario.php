<?php
$page_title = "Editar Usuario";
require 'plantilla_header.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: gestionar_usuarios.php");
    exit();
}

require 'db_config.php';

$id_usuario = $_GET['id'];
$usuario = null;
$plugins = [];
$plugins_usuario = [];

if($conn) {
    // Obtener datos del usuario
    $stmt_user = $conn->prepare("SELECT nombre_usuario, es_admin, is_banned FROM usuarios WHERE id = ?");
    $stmt_user->bind_param("i", $id_usuario);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    if ($result_user->num_rows === 1) {
        $usuario = $result_user->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Usuario no encontrado.";
        header("Location: gestionar_usuarios.php");
        exit();
    }
    $stmt_user->close();

    // Obtener todos los plugins para el dropdown
    $sql_plugins = "SELECT id, nombre FROM plugins";
    $result_plugins = $conn->query($sql_plugins);
    if($result_plugins) $plugins = $result_plugins->fetch_all(MYSQLI_ASSOC);

    // Obtener los IDs de los plugins que el usuario ya tiene
    $stmt_owned = $conn->prepare("SELECT id_plugin FROM compras WHERE id_usuario = ?");
    $stmt_owned->bind_param("i", $id_usuario);
    $stmt_owned->execute();
    $result_owned = $stmt_owned->get_result();
    if($result_owned) {
        while($row = $result_owned->fetch_assoc()) {
            $plugins_usuario[] = $row['id_plugin'];
        }
    }
    $stmt_owned->close();
    $conn->close();
}
?>

<div class="py-12">
     <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold">Editando a <span class="gradient-text"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></span></h1>
                <p class="text-text-secondary">Modifica el estado y los plugins del usuario.</p>
            </div>
            <a href="gestionar_usuarios.php" class="text-sm font-semibold text-accent-primary hover:text-accent-secondary transition">Volver a la lista</a>
        </div>

        <div class="space-y-8">
            <form class="glass-card p-8 rounded-2xl" action="procesar_edicion_usuario.php" method="POST">
                <h2 class="text-xl font-bold mb-4">Estado de la Cuenta</h2>
                <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                <input type="hidden" name="action" value="update_status">
                <div class="space-y-4">
                    <div>
                        <label class="font-semibold">Rango</label>
                        <select name="es_admin" class="mt-1 block w-full bg-bg-secondary border border-border-color rounded-md p-2">
                            <option value="0" <?php echo !$usuario['es_admin'] ? 'selected' : ''; ?>>Usuario</option>
                            <option value="1" <?php echo $usuario['es_admin'] ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                    </div>
                    <div>
                        <label class="font-semibold">Estado</label>
                         <select name="is_banned" class="mt-1 block w-full bg-bg-secondary border border-border-color rounded-md p-2">
                            <option value="0" <?php echo !$usuario['is_banned'] ? 'selected' : ''; ?>>Activo</option>
                            <option value="1" <?php echo $usuario['is_banned'] ? 'selected' : ''; ?>>Baneado</option>
                        </select>
                    </div>
                </div>
                 <button type="submit" class="w-full mt-6 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-bg-primary bg-accent-primary hover:bg-accent-secondary transition-colors">
                    Actualizar Estado
                </button>
            </form>

            <form class="glass-card p-8 rounded-2xl" action="procesar_edicion_usuario.php" method="POST">
                <h2 class="text-xl font-bold mb-4">Otorgar Plugin</h2>
                 <input type="hidden" name="id_usuario" value="<?php echo $id_usuario; ?>">
                 <input type="hidden" name="action" value="grant_plugin">
                <select name="id_plugin" class="block w-full bg-bg-secondary border border-border-color rounded-md p-2">
                    <option disabled selected>Selecciona un plugin...</option>
                    <?php foreach ($plugins as $plugin): ?>
                        <?php if (!in_array($plugin['id'], $plugins_usuario)): // Solo mostrar plugins que no tiene ?>
                            <option value="<?php echo $plugin['id']; ?>"><?php echo htmlspecialchars($plugin['nombre']); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                 <button type="submit" class="w-full mt-4 py-2 px-4 border border-transparent text-sm font-medium rounded-md text-bg-primary bg-accent-secondary hover:bg-accent-primary transition-colors">
                    Otorgar Plugin
                </button>
            </form>
        </div>
     </div>
</div>

<?php require 'plantilla_footer.php'; ?>