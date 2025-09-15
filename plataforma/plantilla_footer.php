</main>
    <footer class="border-t border-border-color py-8 mt-auto">
        <div class="container mx-auto px-6 text-center text-text-secondary text-sm">
            <p>&copy; <?php echo date("Y"); ?> infinity3113. <span data-lang="rights_reserved">Todos los derechos reservados.</span></p>
        </div>
    </footer>
    <script>
        lucide.createIcons();
        
        const translations = {
            es: {
                // Header
                my_panel: "Mi Panel",
                admin_panel: "Panel Admin",
                logout: "Salir",
                login: "Iniciar Sesión",
                register: "Registrarse",
                // Registro
                register_title: "Crea una nueva cuenta",
                error_prefix: "Error:",
                username_placeholder: "Nombre de Usuario",
                email_placeholder: "Correo Electrónico",
                password_placeholder: "Contraseña",
                register_button: "Registrarme",
                already_account: "¿Ya tienes una cuenta?",
                login_link: "Inicia sesión",
                // Login
                login_title: "Inicia sesión en tu cuenta",
                username_or_email_placeholder: "Nombre de Usuario o Email",
                login_button: "Iniciar Sesión",
                no_account: "¿No tienes cuenta?",
                register_link: "Regístrate aquí",
                // Panel Usuario
                welcome_message: "Bienvenido a tu Panel,",
                panel_subtitle: "Gestiona tu cuenta y accede a todos tus productos desde un solo lugar.",
                customer_role: "Cliente",
                plugins_purchased: "Plugins Comprados:",
                rank: "Rango:",
                rank_user: "Usuario",
                account_settings: "Ajustes de Cuenta",
                plugin_library: "Mi Biblioteca de Plugins",
                oops_problem: "¡Ups! Hubo un problema:",
                acquired_on: "Adquirido el:",
                download_button: "Descargar",
                library_empty: "Tu biblioteca está vacía",
                no_plugins_bought: "Aún no has comprado ningún plugin.",
                explore_plugins: "Explorar Plugins",
                // Footer
                rights_reserved: "Todos los derechos reservados."
            },
            en: {
                // Header
                my_panel: "My Panel",
                admin_panel: "Admin Panel",
                logout: "Logout",
                login: "Login",
                register: "Register",
                // Registro
                register_title: "Create a new account",
                error_prefix: "Error:",
                username_placeholder: "Username",
                email_placeholder: "Email Address",
                password_placeholder: "Password",
                register_button: "Register",
                already_account: "Already have an account?",
                login_link: "Log in",
                // Login
                login_title: "Log in to your account",
                username_or_email_placeholder: "Username or Email",
                login_button: "Log In",
                no_account: "Don't have an account?",
                register_link: "Register here",
                // Panel Usuario
                welcome_message: "Welcome to your Panel,",
                panel_subtitle: "Manage your account and access all your products from one place.",
                customer_role: "Customer",
                plugins_purchased: "Plugins Purchased:",
                rank: "Rank:",
                rank_user: "User",
                account_settings: "Account Settings",
                plugin_library: "My Plugin Library",
                oops_problem: "Oops! There was a problem:",
                acquired_on: "Acquired on:",
                download_button: "Download",
                library_empty: "Your library is empty",
                no_plugins_bought: "You haven't bought any plugins yet.",
                explore_plugins: "Explore Plugins",
                // Footer
                rights_reserved: "All rights reserved."
            }
        };

        function setLanguage(lang) {
            document.querySelectorAll('[data-lang]').forEach(el => {
                const key = el.getAttribute('data-lang');
                if (translations[lang] && translations[lang][key]) {
                    el.textContent = translations[lang][key];
                }
            });
            document.querySelectorAll('[data-lang-placeholder]').forEach(el => {
                const key = el.getAttribute('data-lang-placeholder');
                 if (translations[lang] && translations[lang][key]) {
                    el.placeholder = translations[lang][key];
                }
            });
        }

        // Set language on page load
        const currentLang = document.documentElement.lang;
        setLanguage(currentLang);

    </script>
</body>
</html>