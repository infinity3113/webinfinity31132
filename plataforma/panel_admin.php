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
            <p class="text-text-secondary">Gestiona tus plugins y visualiza el estado de la plataforma.</p>
        </div>
        <a href="subir_plugin.php" class="bg-accent-primary text-bg-primary font-bold py-2 px-4 rounded-lg text-sm hover:scale-105 transition-transform duration-300 flex items-center space-x-2">
            <i data-lucide="upload-cloud" class="w-4 h-4"></i>
            <span>Subir Nuevo Plugin</span>
        </a>
    </div>

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
                                echo '      <button class="p-2 text-text-secondary hover:text-accent-primary transition"><i data-lucide="edit-3" class="w-4 h-4"></i></button>';
                                echo '      <button class="p-2 text-text-secondary hover:text-red-500 transition"><i data-lucide="trash-2" class="w-4 h-4"></i></button>';
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