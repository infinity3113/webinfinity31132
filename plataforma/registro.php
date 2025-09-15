<?php 
$page_title = "Registro";
require 'plantilla_header.php'; 
?>

<div class="flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-text-primary">
                Crea una nueva cuenta
            </h2>
        </div>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg" role="alert">
                <strong class="font-bold">Error:</strong>
                <span><?php echo $_SESSION['error_message']; ?></span>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form class="mt-8 space-y-6 glass-card p-8 rounded-2xl" action="procesar_registro.php" method="POST">
             <div class="rounded-md shadow-sm -space-y-px">
                <input id="username" name="username" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-t-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary focus:z-10 sm:text-sm" placeholder="Nombre de Usuario">
                <input id="email" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary focus:outline-none focus:ring-accent-primary focus:border-accent-primary focus:z-10 sm:text-sm" placeholder="Correo Electrónico">
                <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-b-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary focus:z-10 sm:text-sm" placeholder="Contraseña">
            </div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-bg-primary bg-accent-primary hover:bg-accent-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-secondary transition-colors">
                Registrarme
            </button>
            <p class="text-center text-sm text-text-secondary">
                ¿Ya tienes una cuenta? <a href="login.php" class="font-medium text-accent-primary hover:text-accent-secondary">Inicia sesión</a>
            </p>
        </form>
    </div>
</div>

<?php 
require 'plantilla_footer.php'; 
?>