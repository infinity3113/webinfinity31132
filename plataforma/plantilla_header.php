<?php
// Iniciar sesión en la cabecera para que esté disponible en todas las páginas
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'es';
}
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'en' ? 'en' : 'es';
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit();
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Plataforma'; ?> - Infinity3113</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --bg-primary: #0D1117;
            --bg-secondary: #161B22;
            --text-primary: #E6EDF3;
            --text-secondary: #8B949E;
            --accent-primary: #38BDF8;
            --accent-secondary: #2DD4BF;
            --border-color: #30363D;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }
        .gradient-text {
            background: linear-gradient(90deg, var(--accent-primary), var(--accent-secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }
        .glass-card {
            background-color: rgba(22, 27, 34, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
        }

        /* --- INICIO DE LA CORRECCIÓN DEFINITIVA --- */

        /* Esta regla asegura que el texto que escribes sea siempre visible */
        .appearance-none {
            color: var(--text-primary) !important;
            background-color: var(--bg-secondary) !important;
        }

        /* Regla para el placeholder */
        .placeholder-text-secondary::placeholder {
            color: var(--text-secondary);
            opacity: 0.7; /* Ligeramente más visible */
        }

        /* Regla para el autocompletado de Chrome/Safari */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: var(--text-primary) !important;
            -webkit-box-shadow: 0 0 0 30px var(--bg-secondary) inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        
        /* --- FIN DE LA CORRECCIÓN --- */

    </style>
</head>
<body class="min-h-screen flex flex-col">
    <header class="bg-bg-primary/80 backdrop-blur-sm sticky top-0 z-50 border-b border-border-color">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/infinityweb/" class="flex items-center space-x-2 text-xl font-bold">
                <i data-lucide="code-xml" class="text-accent-primary"></i>
                <span>infinity3113</span>
            </a>
            <div class="flex items-center space-x-6">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/infinityweb/plataforma/panel_usuario.php" class="text-sm font-semibold hover:text-accent-primary transition">Mi Panel</a>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
                        <a href="/infinityweb/plataforma/panel_admin.php" class="text-sm font-semibold hover:text-accent-primary transition">Panel Admin</a>
                    <?php endif; ?>
                    <a href="/infinityweb/plataforma/logout.php" class="text-sm font-semibold hover:text-accent-primary transition">Salir</a>
                <?php else: ?>
                    <a href="/infinityweb/plataforma/login.php" class="text-sm font-semibold hover:text-accent-primary transition">Iniciar Sesión</a>
                    <a href="/infinityweb/plataforma/registro.php" class="bg-accent-primary text-bg-primary font-bold py-2 px-4 rounded-lg text-sm hover:scale-105 transition-transform duration-300">Registrarse</a>
                <?php endif; ?>

                <div class="flex items-center space-x-1 bg-bg-secondary p-1 rounded-lg border border-border-color">
                    <a href="?lang=es" class="px-3 py-1 text-sm rounded-md transition <?php echo $_SESSION['lang'] === 'es' ? 'bg-accent-primary text-bg-primary font-semibold' : 'text-text-secondary'; ?>">ES</a>
                    <a href="?lang=en" class="px-3 py-1 text-sm rounded-md transition <?php echo $_SESSION['lang'] === 'en' ? 'bg-accent-primary text-bg-primary font-semibold' : 'text-text-secondary'; ?>">EN</a>
                </div>
            </div>
        </nav>
    </header>
    <main class="flex-grow container mx-auto px-6">