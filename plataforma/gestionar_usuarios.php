<?php
$page_title = "Gestionar Usuarios";
require 'plantilla_header.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}
require 'db_config.php';

$usuarios = [];
if ($conn) {
    $sql = "SELECT id, nombre_usuario, email, es_admin, is_banned, fecha_registro FROM usuarios ORDER BY id ASC";
    $result = $conn->query($sql);
    if ($result) {
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
    }
    $conn->close();
}
?>

<div class="py-12">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold">Gestionar Usuarios</h1>
            <p class="text-text-secondary">Administra los roles, permisos y estado de todos los usuarios.</p>
        </div>
         <a href="panel_admin.php" class="text-sm font-semibold text-accent-primary hover:text-accent-secondary transition">Volver al Panel</a>
    </div>

    <div class="glass-card rounded-2xl p-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="border-b border-border-color">
                    <tr>
                        <th class="p-4 text-text-secondary font-semibold">Usuario</th>
                        <th class="p-4 text-text-secondary font-semibold">Email</th>
                        <th class="p-4 text-text-secondary font-semibold">Rango</th>
                        <th class="p-4 text-text-secondary font-semibold">Estado</th>
                        <th class="p-4 text-text-secondary font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr><td colspan="5" class='p-4 text-text-secondary text-center'>No hay usuarios registrados.</td></tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr class="border-b border-border-color last:border-b-0">
                                <td class="p-4 font-bold"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                                <td class="p-4 text-text-secondary"><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td class="p-4">
                                    <?php if ($usuario['es_admin']): ?>
                                        <span class="font-semibold bg-accent-primary/10 text-accent-primary py-1 px-2 rounded-md text-xs">Admin</span>
                                    <?php else: ?>
                                        <span class="font-semibold bg-bg-secondary text-text-secondary py-1 px-2 rounded-md text-xs">Usuario</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4">
                                     <?php if ($usuario['is_banned']): ?>
                                        <span class="font-semibold bg-red-500/10 text-red-400 py-1 px-2 rounded-md text-xs">Baneado</span>
                                    <?php else: ?>
                                        <span class="font-semibold bg-green-500/10 text-green-400 py-1 px-2 rounded-md text-xs">Activo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-right">
                                     <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="p-2 text-text-secondary hover:text-accent-primary transition"><i data-lucide="settings-2" class="w-4 h-4"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require 'plantilla_footer.php'; ?>