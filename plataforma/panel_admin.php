<?php
$page_title = "Panel de Administración";
require 'plantilla_header.php';

// DOBLE VERIFICACIÓN DE SEGURIDAD
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}
require 'db_config.php';
?>

<div class="py-12">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold">Panel de Administración</h1>
            <p class="text-text-secondary">Gestiona tus plugins y usuarios desde aquí.</p>
        </div>
        <div class="flex space-x-2">
            <a href="gestionar_usuarios.php" class="bg-bg-secondary border border-border-color text-text-primary font-bold py-2 px-4 rounded-lg text-sm hover:border-accent-secondary transition-colors duration-300 flex items-center space-x-2">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Gestionar Usuarios</span>
            </a>
            <a href="subir_plugin.php" class="bg-accent-primary text-bg-primary font-bold py-2 px-4 rounded-lg text-sm hover:scale-105 transition-transform duration-300 flex items-center space-x-2">
                <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                <span>Subir Nuevo Plugin</span>
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-lg mb-6" role="alert">
            <strong class="font-bold">¡Éxito!</strong>
            <span><?php echo $_SESSION['success_message']; ?></span>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg mb-6" role="alert">
            <strong class="font-bold">Error:</strong>
            <span><?php echo $_SESSION['error_message']; ?></span>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="glass-card rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-6 border-b border-border-color pb-4">Plugins Existentes</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="border-b border-border-color">
                    <tr>
                        <th class="p-4 text-text-secondary font-semibold">Nombre</th>
                        <th class="p-4 text-text-secondary font-semibold">Descripción</th>
                        <th class="p-4 text-text-secondary font-semibold">Precio</th>
                        <th class="p-4 text-text-secondary font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($conn === null) {
                        echo "<tr><td colspan='4' class='p-4 text-red-400'>Error: No se pudo conectar a la base de datos.</td></tr>";
                    } else {
                        $sql = "SELECT id, nombre, descripcion_corta, precio FROM plugins ORDER BY id DESC";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<tr class="border-b border-border-color last:border-b-0">';
                                echo '<td class="p-4 font-bold">' . htmlspecialchars($row['nombre']) . '</td>';
                                echo '<td class="p-4 text-text-secondary">' . htmlspecialchars($row['descripcion_corta']) . '</td>';
                                echo '<td class="p-4 font-semibold text-accent-secondary">$' . htmlspecialchars($row['precio']) . '</td>';
                                echo '<td class="p-4 text-right">';
                                echo '  <div class="flex justify-end space-x-2">';
                                echo '      <a href="editar_plugin.php?id=' . $row['id'] . '" class="p-2 text-text-secondary hover:text-accent-primary transition"><i data-lucide="edit-3" class="w-4 h-4"></i></a>';
                                echo '      <a href="eliminar_plugin.php?id=' . $row['id'] . '" onclick="return confirm(\'¿Estás seguro de que quieres eliminar este plugin? Esta acción no se puede deshacer.\')" class="p-2 text-text-secondary hover:text-red-500 transition"><i data-lucide="trash-2" class="w-4 h-4"></i></a>';
                                echo '  </div>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo "<tr><td colspan='4' class='p-4 text-text-secondary text-center'>Aún no has subido ningún plugin.</td></tr>";
                        }
                        $conn->close();
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

<?php require 'plantilla_footer.php'; ?>