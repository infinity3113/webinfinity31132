<?php 
$page_title = "Registro";
require 'plantilla_header.php'; 
?>

<div class="flex items-center justify-center py-12">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-text-primary" data-lang="register_title">
                Crea una nueva cuenta
            </h2>
        </div>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-lg" role="alert">
                <strong class="font-bold" data-lang="error_prefix">Error:</strong>
                <span data-lang="<?php echo $_SESSION['error_message_key']; ?>"><?php echo $_SESSION['error_message']; ?></span>
            </div>
            <?php unset($_SESSION['error_message'], $_SESSION['error_message_key']); ?>
        <?php endif; ?>

        <form class="mt-8 space-y-6 glass-card p-8 rounded-2xl" action="procesar_registro.php" method="POST">
             <div class="rounded-md shadow-sm -space-y-px">
                <input id="username" name="username" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-t-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary focus:z-10 sm:text-sm" placeholder="Nombre de Usuario" data-lang-placeholder="username_placeholder">
                <input id="email" name="email" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary focus:outline-none focus:ring-accent-primary focus:border-accent-primary focus:z-10 sm:text-sm" placeholder="Correo Electrónico" data-lang-placeholder="email_placeholder">
                <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-3 border border-border-color bg-bg-secondary placeholder-text-secondary text-text-primary rounded-b-md focus:outline-none focus:ring-accent-primary focus:border-accent-primary focus:z-10 sm:text-sm" placeholder="Contraseña" data-lang-placeholder="password_placeholder">
            </div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-bg-primary bg-accent-primary hover:bg-accent-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-secondary transition-colors" data-lang="register_button">
                Registrarme
            </button>
            <p class="text-center text-sm text-text-secondary">
                <span data-lang="already_account">¿Ya tienes una cuenta?</span> <a href="login.php" class="font-medium text-accent-primary hover:text-accent-secondary" data-lang="login_link">Inicia sesión</a>
            </p>
        </form>
    </div>
</div>

<?php 
require 'plantilla_footer.php'; 
?>