<?php
$page_title = "Subir Plugin";
require 'plantilla_header.php';

// Verificación de seguridad
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php");
    exit();
}
?>

<div class="flex items-center justify-center py-12">
    <div class="max-w-lg w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-text-primary">
                Subir un Nuevo Plugin
            </h2>
            <p class="mt-2 text-center text-sm text-text-secondary">
                Completa los detalles para añadir tu creación a la plataforma.
            </p>
        </div>
        
        <form class="mt-8 space-y-6 glass-card p-8 rounded-2xl" action="procesar_subida.php" method="POST" enctype="multipart/form-data">
             <div class="space-y-4">
                <div>
                    <label for="nombre" class="text-sm font-medium text-text-secondary">Nombre del Plugin</label>
                    <input id="nombre" name="nombre" type="text" required class="mt-1 appearance-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary sm:text-sm">
                </div>
                 <div>
                    <label for="descripcion_corta" class="text-sm font-medium text-text-secondary">Descripción Corta</label>
                    <textarea id="descripcion_corta" name="descripcion_corta" rows="3" required class="mt-1 appearance-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary sm:text-sm"></textarea>
                </div>
                <div>
                    <label for="precio" class="text-sm font-medium text-text-secondary">Precio (USD)</label>
                    <input id="precio" name="precio" type="number" step="0.01" required class="mt-1 appearance-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary sm:text-sm" placeholder="9.99">
                </div>
                 <div>
                    <label for="plugin_file" class="text-sm font-medium text-text-secondary">Archivo del Plugin (.jar)</label>
                    <input type="file" id="plugin_file" name="plugin_file" accept=".jar" required class="mt-1 block w-full text-sm text-text-secondary file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-accent-primary/10 file:text-accent-primary hover:file:bg-accent-primary/20">
                </div>
            </div>
            
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-bg-primary bg-accent-primary hover:bg-accent-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-secondary transition-colors">
                Subir Plugin
            </button>
            <p class="text-center text-sm">
                <a href="panel_admin.php" class="font-medium text-accent-primary hover:text-accent-secondary">Cancelar y volver al panel</a>
            </p>
        </form>
    </div>
</div>

<?php require 'plantilla_footer.php'; ?>