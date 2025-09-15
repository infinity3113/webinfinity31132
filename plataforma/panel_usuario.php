<?php
$page_title = "Panel de Usuario";
require 'plantilla_header.php';

// Guardián de la página
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'db_config.php';

// Preparamos los datos que necesitaremos
$plugins_comprados = [];
$total_plugins = 0;
$error_message = null; 

if ($conn === null) {
    $error_message = "Error Crítico: No se pudo establecer la conexión con la base de datos.";
} else {
    $id_usuario_actual = $_SESSION['user_id'];
    
    // --- INICIO DE LA CORRECCIÓN ---
    // Se agrupan los resultados por el ID del plugin para evitar mostrar duplicados.
    // Se utiliza MIN(c.fecha_compra) para mostrar la fecha de la primera adquisición.
    $sql = "SELECT p.id, p.nombre, MIN(c.fecha_compra) as fecha_compra 
            FROM plugins p 
            JOIN compras c ON p.id = c.id_plugin 
            WHERE c.id_usuario = ? 
            GROUP BY p.id, p.nombre
            ORDER BY fecha_compra DESC";
    // --- FIN DE LA CORRECCIÓN ---
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id_usuario_actual);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result) {
                $plugins_comprados = $result->fetch_all(MYSQLI_ASSOC);
                $total_plugins = count($plugins_comprados);
            } else {
                $error_message = "Error al obtener los resultados de la consulta.";
            }
        } else {
            $error_message = "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "Error al preparar la consulta: " . $conn->error;
    }
    $conn->close();
}
?>

<div class="py-12">
    <div>
        <h1 class="text-3xl font-bold" data-lang="welcome_message">Bienvenido a tu Panel, <span class="gradient-text"><?php echo htmlspecialchars($_SESSION['username']); ?></span></h1>
        <p class="text-text-secondary mt-1" data-lang="panel_subtitle">Gestiona tu cuenta y accede a todos tus productos desde un solo lugar.</p>
    </div>

    <div class="mt-10 md:flex md:space-x-8">

        <aside class="md:w-1/3 lg:w-1/4 mb-8 md:mb-0">
            <div class="glass-card rounded-2xl p-6 sticky top-24">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="bg-bg-secondary p-3 rounded-full border border-border-color">
                        <i data-lucide="user-circle" class="w-8 h-8 text-accent-primary"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg"><?php echo htmlspecialchars($_SESSION['username']); ?></h3>
                        <p class="text-xs text-text-secondary" data-lang="customer_role">Cliente</p>
                    </div>
                </div>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between items-center">
                        <span class="text-text-secondary" data-lang="plugins_purchased">Plugins Comprados:</span>
                        <span class="font-bold bg-accent-secondary/10 text-accent-secondary py-1 px-2 rounded-md"><?php echo $total_plugins; ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-text-secondary" data-lang="rank">Rango:</span>
                        <span class="font-bold text-text-primary" data-lang="rank_user">Usuario</span>
                    </div>
                </div>
                <a href="#" class="mt-6 block w-full text-center bg-bg-secondary border border-border-color rounded-lg py-2 text-sm font-semibold hover:border-accent-primary transition" data-lang="account_settings">
                    Ajustes de Cuenta
                </a>
            </div>
        </aside>

        <div class="md:w-2/3 lg:w-3/4">
            <div class="glass-card rounded-2xl p-8">
                <h2 class="text-2xl font-bold mb-6 border-b border-border-color pb-4 flex items-center space-x-2">
                    <i data-lucide="library" class="w-6 h-6"></i>
                    <span data-lang="plugin_library">Mi Biblioteca de Plugins</span>
                </h2>
                <div class="space-y-4">
                    <?php if ($error_message !== null): ?>
                        <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg" role="alert">
                            <strong class="font-bold" data-lang="oops_problem">¡Ups! Hubo un problema:</strong>
                            <span class="block sm:inline"><?php echo htmlspecialchars($error_message); ?></span>
                        </div>
                    <?php elseif ($total_plugins > 0): ?>
                        <?php foreach ($plugins_comprados as $plugin): ?>
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-bg-secondary p-4 rounded-lg border border-border-color hover:border-accent-secondary transition-all duration-300">
                                <div class="mb-4 sm:mb-0">
                                    <div class="flex items-center space-x-3 mb-1">
                                        <i data-lucide="package-check" class="w-6 h-6 text-accent-secondary flex-shrink-0"></i>
                                        <h3 class="font-semibold text-lg"><?php echo htmlspecialchars($plugin['nombre']); ?></h3>
                                    </div>
                                    <p class="text-xs text-text-secondary ml-9">
                                        <span data-lang="acquired_on">Adquirido el:</span> 
                                        <?php 
                                            $date = new DateTime($plugin['fecha_compra']);
                                            echo $date->format('d/m/Y'); 
                                        ?>
                                    </p>
                                </div>
                                <a href="descargar.php?id=<?php echo $plugin['id']; ?>" class="w-full sm:w-auto bg-accent-primary text-bg-primary font-bold py-2 px-4 rounded-lg text-sm hover:scale-105 transition-transform duration-300 flex items-center justify-center space-x-2">
                                    <i data-lucide="download-cloud" class="w-4 h-4"></i>
                                    <span data-lang="download_button">Descargar</span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <i data-lucide="shopping-cart" class="w-12 h-12 text-text-secondary mx-auto mb-4"></i>
                            <h3 class="font-bold text-lg" data-lang="library_empty">Tu biblioteca está vacía</h3>
                            <p class="text-text-secondary text-sm" data-lang="no_plugins_bought">Aún no has comprado ningún plugin.</p>
                            <a href="/infinityweb/" class="mt-4 inline-block bg-accent-primary text-bg-primary font-bold py-2 px-4 rounded-lg text-sm hover:scale-105 transition-transform duration-300" data-lang="explore_plugins">
                                Explorar Plugins
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require 'plantilla_footer.php'; ?>