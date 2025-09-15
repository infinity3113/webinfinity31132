<?php
// --- INICIO DE LA CORRECCIÓN ---
// Se inicia la sesión para poder comprobar si el usuario está logueado.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// --- FIN DE LA CORRECCIÓN ---

// Conexión a la base de datos para obtener los plugins
require 'plataforma/db_config.php';

$plugins = [];
$plugins_usuario = []; // <--- NUEVO: Array para guardar los plugins del usuario

if (isset($conn) && $conn !== null) {
    // --- OBTENER PLUGINS DEL USUARIO SI ESTÁ LOGUEADO ---
    if (isset($_SESSION['user_id'])) {
        $id_usuario_actual = $_SESSION['user_id'];
        $sql_usuario = "SELECT id_plugin FROM compras WHERE id_usuario = ?";
        $stmt_usuario = $conn->prepare($sql_usuario);
        $stmt_usuario->bind_param("i", $id_usuario_actual);
        $stmt_usuario->execute();
        $result_usuario = $stmt_usuario->get_result();
        while ($row = $result_usuario->fetch_assoc()) {
            $plugins_usuario[] = $row['id_plugin'];
        }
        $stmt_usuario->close();
    }

    // Obtener todos los plugins
    $sql_plugins = "SELECT id, nombre, descripcion_corta, precio FROM plugins ORDER BY id DESC";
    $result_plugins = $conn->query($sql_plugins);
    if ($result_plugins && $result_plugins->num_rows > 0) {
        while($plugin_data = $result_plugins->fetch_assoc()) {
            $plugins[] = $plugin_data;
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinity3113 - Minecraft Plugin Developer</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --bg-primary: #0D1117;
            --bg-secondary: #161B22;
            --text-primary: #E6EDF3;
            --text-secondary: #8B949E;
            --accent-primary: #38BDF8; /* sky-400 */
            --accent-secondary: #2DD4BF; /* teal-400 */
            --border-color: #30363D;
        }
        html {
             scroll-behavior: smooth;
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
            background-color: rgba(22, 27, 34, 0.5);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
        }
        .swiper-button-next, .swiper-button-prev {
            color: var(--accent-primary);
            transition: color 0.3s ease;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            color: var(--accent-secondary);
        }
        .swiper-pagination-bullet-active {
            background-color: var(--accent-primary);
        }
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="overflow-x-hidden">

    <header id="header" class="bg-bg-primary/80 backdrop-blur-sm fixed top-0 left-0 right-0 z-50 border-b border-border-color transition-all duration-300">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/infinityweb/" class="flex items-center space-x-2 text-xl font-bold">
                <i data-lucide="code-xml" class="text-accent-primary"></i>
                <span>infinity3113</span>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="#about" class="text-text-secondary hover:text-text-primary transition" data-lang="nav_about">Sobre Mí</a>
                <a href="#plugins" class="text-text-secondary hover:text-text-primary transition" data-lang="nav_plugins">Plugins</a>
                <a href="#wiki" class="text-text-secondary hover:text-text-primary transition" data-lang="nav_wiki">Wiki</a>
                <a href="#contact" class="text-text-secondary hover:text-text-primary transition" data-lang="nav_contact">Contacto</a>
            </div>

            <div class="flex items-center space-x-4">
                 <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/infinityweb/plataforma/panel_usuario.php" class="hidden md:flex items-center space-x-2 text-sm bg-bg-secondary px-4 py-2 rounded-lg border border-border-color hover:border-accent-primary transition">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span data-lang="nav_panel">Mi Panel</span>
                    </a>
                <?php else: ?>
                    <a href="/infinityweb/plataforma/login.php" class="hidden md:flex items-center space-x-2 text-sm bg-bg-secondary px-4 py-2 rounded-lg border border-border-color hover:border-accent-primary transition">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span data-lang="nav_account">Mi Cuenta</span>
                    </a>
                <?php endif; ?>
                
                <div class="flex items-center space-x-1 bg-bg-secondary p-1 rounded-lg border border-border-color">
                    <button id="lang-es" class="px-3 py-1 text-sm rounded-md transition bg-accent-primary text-bg-primary font-semibold">ES</button>
                    <button id="lang-en" class="px-3 py-1 text-sm rounded-md transition text-text-secondary font-semibold">EN</button>
                </div>
                <button id="mobile-menu-btn" class="md:hidden">
                    <i data-lucide="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </nav>
         <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-bg-secondary border-t border-border-color">
            <div class="flex flex-col items-center space-y-4 p-6">
                <a href="#about" class="text-text-secondary hover:text-text-primary transition" data-lang="nav_about_mobile">Sobre Mí</a>
                <a href="#plugins" class="text-text-secondary hover:text-text-primary transition" data-lang="nav_plugins_mobile">Plugins</a>
                <a href="#wiki" class="text-text-secondary hover:text-text-primary transition" data-lang="nav_wiki_mobile">Wiki</a>
                <a href="#contact" class="text-text-secondary hover:text-text-primary transition" data-lang="nav_contact_mobile">Contacto</a>
                 <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/infinityweb/plataforma/panel_usuario.php" class="flex items-center space-x-2 text-sm bg-bg-primary px-4 py-2 rounded-lg border border-border-color hover:border-accent-primary transition w-full justify-center">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span data-lang="nav_panel_mobile">Mi Panel</span>
                    </a>
                <?php else: ?>
                     <a href="/infinityweb/plataforma/login.php" class="flex items-center space-x-2 text-sm bg-bg-primary px-4 py-2 rounded-lg border border-border-color hover:border-accent-primary transition w-full justify-center">
                        <i data-lucide="user" class="w-4 h-4"></i>
                        <span data-lang="nav_account_mobile">Mi Cuenta</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <section class="h-screen min-h-[600px] flex items-center justify-center text-center relative overflow-hidden">
             <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
             <div class="absolute inset-0 bg-gradient-to-b from-transparent to-bg-primary"></div>

            <div class="container mx-auto px-6 z-10">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-black tracking-tighter mb-4" data-lang="hero_title">
                    Plugins de Minecraft de <span class="gradient-text">Calidad Excepcional</span>
                </h1>
                <p class="text-lg md:text-xl text-text-secondary max-w-3xl mx-auto mb-8" data-lang="hero_subtitle">
                    Potenciando servidores con herramientas robustas, innovadoras y optimizadas para el mejor rendimiento.
                </p>
                <a href="#plugins" class="bg-accent-primary text-bg-primary font-bold py-3 px-8 rounded-lg text-lg hover:scale-105 hover:shadow-2xl hover:shadow-accent-primary/20 transition-transform duration-300" data-lang="hero_cta">
                    Explorar Plugins
                </a>
            </div>
        </section>

        <section id="features" class="py-24">
            <div class="container mx-auto px-6">
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="reveal glass-card p-8 rounded-xl">
                        <div class="flex justify-center mb-4">
                            <div class="bg-accent-primary/10 p-4 rounded-full">
                                <i data-lucide="zap" class="w-8 h-8 text-accent-primary"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2" data-lang="feature1_title">Alto Rendimiento</h3>
                        <p class="text-text-secondary" data-lang="feature1_desc">Optimizados al máximo para no afectar el TPS de tu servidor.</p>
                    </div>
                    <div class="reveal glass-card p-8 rounded-xl" style="transition-delay: 150ms;">
                         <div class="flex justify-center mb-4">
                            <div class="bg-accent-primary/10 p-4 rounded-full">
                                <i data-lucide="settings-2" class="w-8 h-8 text-accent-primary"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2" data-lang="feature2_title">Fácil Configuración</h3>
                        <p class="text-text-secondary" data-lang="feature2_desc">Archivos de configuración intuitivos y documentación clara.</p>
                    </div>
                    <div class="reveal glass-card p-8 rounded-xl" style="transition-delay: 300ms;">
                         <div class="flex justify-center mb-4">
                            <div class="bg-accent-primary/10 p-4 rounded-full">
                                <i data-lucide="life-buoy" class="w-8 h-8 text-accent-primary"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-2" data-lang="feature3_title">Soporte Confiable</h3>
                        <p class="text-text-secondary" data-lang="feature3_desc">Asistencia rápida y eficaz para resolver cualquier duda o problema.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="py-24 bg-bg-secondary">
             <div class="container mx-auto px-6 reveal">
                    <div class="glass-card rounded-2xl p-8 md:p-12">
                        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
                            <div class="w-full md:w-1/3 flex-shrink-0">
                                <div class="w-48 h-48 md:w-60 md:h-60 mx-auto bg-bg-secondary rounded-full flex items-center justify-center border-2 border-accent-primary shadow-lg p-4">
                                    <i data-lucide="code-2" class="w-24 h-24 text-accent-primary/70"></i>
                                </div>
                            </div>
                            <div class="w-full md:w-2/3 text-center md:text-left">
                                <h2 class="text-3xl md:text-4xl font-extrabold mb-2 gradient-text">infinity3113</h2>
                                <p class="text-lg text-accent-primary mb-4 font-medium" data-lang="about_role">Creador, Programador y Entusiasta de Minecraft</p>
                                <p class="text-text-secondary" data-lang="about_desc">
                                    ¡Hola! Soy un apasionado desarrollador de plugins de Minecraft. Lo que comenzó como una simple curiosidad por modificar el universo de los cubos, rápidamente se transformó en una verdadera vocación. Mi filosofía se centra en la calidad, el rendimiento y la innovación.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <section id="plugins" class="py-24">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12 reveal">
                    <h2 class="text-3xl md:text-5xl font-black tracking-tight" data-lang="plugins_title">Mis Creaciones</h2>
                    <p class="text-lg text-text-secondary mt-2 max-w-2xl mx-auto" data-lang="plugins_subtitle">Cada plugin está diseñado con atención al detalle y un enfoque en la calidad.</p>
                </div>

                <div class="swiper plugin-swiper reveal">
                    <div class="swiper-wrapper pb-12">
                        <?php if (!empty($plugins)): ?>
                            <?php foreach ($plugins as $plugin): ?>
                                <div class="swiper-slide h-full">
                                    <div class="glass-card rounded-2xl p-8 flex flex-col h-full text-center hover:border-accent-secondary transition-colors duration-300">
                                        <div class="flex-grow">
                                            <i data-lucide="package-check" class="w-12 h-12 text-accent-secondary mx-auto mb-4"></i>
                                            <h3 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($plugin['nombre']); ?></h3>
                                            <p class="text-text-secondary mb-4 text-sm"><?php echo htmlspecialchars($plugin['descripcion_corta']); ?></p>
                                        </div>
                                        <div class="mt-auto">
                                            <?php
                                            // --- INICIO DE LA LÓGICA DEL BOTÓN INTELIGENTE ---
                                            $ya_adquirido = in_array($plugin['id'], $plugins_usuario);
                                            
                                            if ($ya_adquirido) {
                                                // Botón para plugin ya adquirido
                                                echo '<p class="text-3xl font-black gradient-text mb-6" data-lang="owned_text">Ya Adquirido</p>';
                                                echo '<a href="plataforma/panel_usuario.php" class="w-full block bg-bg-secondary text-text-secondary font-bold py-3 px-6 rounded-lg border border-border-color cursor-pointer hover:border-accent-primary transition-colors" data-lang="go_to_panel_btn">Ir al Panel</a>';
                                            } else {
                                                // Lógica para plugins no adquiridos
                                                if (floatval($plugin['precio']) > 0) {
                                                    // Botón para comprar (deshabilitado temporalmente)
                                                    echo '<p class="text-3xl font-black gradient-text mb-6">$'.htmlspecialchars($plugin['precio']).'</p>';
                                                    echo '<button type="button" onclick="alert(\'Por los momentos no puedes comprar, pronto se habilitará. Escribe al discord infinity3113 para obtener respuestas.\')" class="w-full bg-accent-secondary text-bg-primary font-bold py-3 px-6 rounded-lg hover:scale-105 transition-transform duration-300" data-lang="buy_now_btn">Comprar Ahora</button>';
                                                } else {
                                                    // Botón para reclamar gratis
                                                    echo '<p class="text-3xl font-black gradient-text mb-6" data-lang="free_text">Gratis</p>';
                                                    echo '<form action="plataforma/comprar_plugin.php" method="POST">';
                                                    echo '<input type="hidden" name="id_plugin" value="'.$plugin['id'].'">';
                                                    echo '<button type="submit" class="w-full bg-accent-primary text-bg-primary font-bold py-3 px-6 rounded-lg hover:scale-105 transition-transform duration-300" data-lang="claim_now_btn">Reclamar Ahora</button>';
                                                    echo '</form>';
                                                }
                                            }
                                            // --- FIN DE LA LÓGICA DEL BOTÓN INTELIGENTE ---
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="swiper-slide">
                                <div class="glass-card rounded-2xl p-8 text-center">
                                    <i data-lucide="server-crash" class="w-12 h-12 text-accent-primary mx-auto mb-4"></i>
                                    <h3 class="text-2xl font-bold mb-2" data-lang="no_plugins_title">No hay plugins</h3>
                                    <p class="text-text-secondary" data-lang="no_plugins_desc">Aún no se han subido plugins. ¡Vuelve pronto!</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="swiper-pagination mt-8 !relative"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>

        <section id="wiki" class="py-24 bg-bg-secondary">
            <div class="container mx-auto px-6 reveal">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-5xl font-black tracking-tight" data-lang="wiki_title">Wiki & Documentación</h2>
                    <p class="text-lg text-text-secondary mt-2 max-w-2xl mx-auto" data-lang="wiki_subtitle">Guías detalladas y explicaciones para sacar el máximo provecho a mis plugins.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <div class="glass-card rounded-2xl p-8 md:p-12 flex flex-col">
                        <div class="flex-grow flex flex-col md:flex-row items-center gap-8">
                            <div class="md:w-1/4 text-center">
                               <i data-lucide="gem" class="w-24 h-24 text-accent-secondary mx-auto"></i>
                            </div>
                            <div class="md:w-3/4">
                                <a href="wiki.php" class="text-2xl font-bold mb-3 gradient-text hover:brightness-125 transition" data-lang="slotmachine_title">SlotMachine Plugin</a>
                                <p class="text-text-secondary" data-lang="slotmachine_desc">
                                    Añade una máquina tragamonedas funcional y personalizable. Ideal para economías de servidor que buscan añadir un elemento de suerte y diversión.
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 text-center">
                            <a href="wiki.php" class="font-bold text-accent-primary hover:text-accent-secondary transition">Ver Documentación &rarr;</a>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-8 md:p-12 flex flex-col">
                        <div class="flex-grow flex flex-col md:flex-row items-center gap-8">
                            <div class="md:w-1/4 text-center">
                               <i data-lucide="bar-chart-4" class="w-24 h-24 text-accent-primary mx-auto"></i>
                            </div>
                            <div class="md:w-3/4">
                                <a href="rankupik-wiki.php" class="text-2xl font-bold mb-3 gradient-text hover:brightness-125 transition">RankupIK Plugin</a>
                                <p class="text-text-secondary">
                                    Un sistema de rangos avanzado donde los jugadores ascienden cumpliendo objetivos basados en sus estadísticas de juego, como minería, combate y más.
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 text-center">
                            <a href="rankupik-wiki.php" class="font-bold text-accent-primary hover:text-accent-secondary transition">Ver Documentación &rarr;</a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section id="contact" class="py-24 text-center">
             <div class="container mx-auto px-6 reveal">
                 <h2 class="text-3xl md:text-5xl font-black tracking-tight" data-lang="contact_title">¿Interesado? Hablemos.</h2>
                 <p class="text-lg text-text-secondary mt-2 max-w-2xl mx-auto mb-8" data-lang="contact_subtitle">Estoy disponible para comisiones personalizadas, soporte o cualquier otra consulta.</p>
                 <a href="#" class="bg-[#5865F2] text-white font-bold py-3 px-8 rounded-lg text-lg hover:scale-105 hover:shadow-2xl hover:shadow-[#5865F2]/20 transition-transform duration-300 inline-flex items-center space-x-3">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true" role="img">
                        <path d="M13.545 2.907a13.227 13.227 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833a12.19 12.19 0 0 0-3.658 0 8.258 8.258 0 0 0-.412-.833.051.051 0 0 0-.052-.025c-1.125.194-2.22.534-3.257 1.011a.041.041 0 0 0-.021.018C.356 6.024-.213 9.047.066 12.032c.001.014.01.028.021.037a13.276 13.276 0 0 0 3.995 2.02.05.05 0 0 0 .056-.019c.308-.42.582-.863.818-1.329a.05.05 0 0 0-.01-.059.051.051 0 0 0-.018-.011 8.875 8.875 0 0 1-1.248-.595.05.05 0 0 1-.02-.066.051.051 0 0 1 .015-.019c.084-.063.168-.129.248-.195a.05.05 0 0 1 .051-.007c2.619 1.165 5.578 1.165 8.197 0a.05.05 0 0 1 .053.007c.08.066.164.132.248.195a.051.051 0 0 1 .015.019.05.05 0 0 1-.02.066 8.875 8.875 0 0 1-1.248.595.05.05 0 0 0-.01.059c.236.466.51.899.818 1.329a.05.05 0 0 0 .056.019 13.276 13.276 0 0 0 3.995-2.02.051.051 0 0 0 .021-.037c.279-2.985-.093-6.008-.698-9.125a.041.041 0 0 0-.021-.018zM4.522 10.187a1.538 1.538 0 0 1-1.54-1.543 1.54 1.54 0 0 1 1.54-1.543c.849 0 1.54.695 1.54 1.543s-.691 1.543-1.54 1.543zm6.956 0a1.538 1.538 0 0 1-1.54-1.543 1.54 1.54 0 0 1 1.54-1.543c.849 0 1.54.695 1.54 1.543s-.691 1.543-1.54 1.543z"></path>
                    </svg>
                    <span>infinity3113</span>
                 </a>
             </div>
        </section>

    </main>

    <footer class="border-t border-border-color py-8">
        <div class="container mx-auto px-6 text-center text-text-secondary text-sm">
            <p>&copy; <span id="year"></span> infinity3113. Todos los derechos reservados.</p>
            <p data-lang="footer_love">Hecho con ❤️ para la comunidad de Minecraft.</p>
        </div>
    </footer>
    
    <script>
        // Create icons
        lucide.createIcons();

        // Set current year in footer
        document.getElementById('year').textContent = new Date().getFullYear();
        
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Scroll animations
        const revealElements = document.querySelectorAll('.reveal');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.1 });
        revealElements.forEach(el => revealObserver.observe(el));
        
        // Swiper Initialization
        const swiper = new Swiper('.plugin-swiper', {
            loop: false,
            slidesPerView: 1,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            },
        });

        // Language Translation
        const translations = {
            es: {
                nav_about: "Sobre Mí", nav_plugins: "Plugins", nav_wiki: "Wiki", nav_contact: "Contacto", nav_account: "Mi Cuenta", nav_panel: "Mi Panel",
                nav_about_mobile: "Sobre Mí", nav_plugins_mobile: "Plugins", nav_wiki_mobile: "Wiki", nav_contact_mobile: "Contacto", nav_account_mobile: "Mi Cuenta", nav_panel_mobile: "Mi Panel",
                hero_title: "Plugins de Minecraft de Calidad Excepcional",
                hero_subtitle: "Potenciando servidores con herramientas robustas, innovadoras y optimizadas para el mejor rendimiento.",
                hero_cta: "Explorar Plugins",
                feature1_title: "Alto Rendimiento", feature1_desc: "Optimizados al máximo para no afectar el TPS de tu servidor.",
                feature2_title: "Fácil Configuración", feature2_desc: "Archivos de configuración intuitivos y documentación clara.",
                feature3_title: "Soporte Confiable", feature3_desc: "Asistencia rápida y eficaz para resolver cualquier duda o problema.",
                plugins_title: "Mis Creaciones", plugins_subtitle: "Cada plugin está diseñado con atención al detalle y un enfoque en la calidad.",
                buy_now_btn: "Comprar Ahora",
                claim_now_btn: "Reclamar Ahora",
                free_text: "Gratis",
                owned_text: "Ya Adquirido",
                go_to_panel_btn: "Ir al Panel",
                no_plugins_title: "No hay plugins", no_plugins_desc: "Aún no se han subido plugins. ¡Vuelve pronto!",
                about_role: "Creador, Programador y Entusiasta de Minecraft",
                about_desc: "¡Hola! Soy un apasionado desarrollador de plugins de Minecraft. Lo que comenzó como una simple curiosidad por modificar el universo de los cubos, rápidamente se transformó en una verdadera vocación. Mi filosofía se centra en la calidad, el rendimiento y la innovación.",
                wiki_title: "Wiki & Documentación", wiki_subtitle: "Guías detalladas y explicaciones para sacar el máximo provecho a mis plugins.",
                slotmachine_title: "SlotMachine Plugin", slotmachine_desc: "Añade una máquina tragamonedas funcional y personalizable. Ideal para economías de servidor que buscan añadir un elemento de suerte y diversión.",
                contact_title: "¿Interesado? Hablemos.", contact_subtitle: "Estoy disponible para comisiones personalizadas, soporte o cualquier otra consulta.",
                contact_cta: "Contactar por Email",
                footer_love: "Hecho con ❤️ para la comunidad de Minecraft."
            },
            en: {
                nav_about: "About Me", nav_plugins: "Plugins", nav_wiki: "Wiki", nav_contact: "Contact", nav_account: "My Account", nav_panel: "My Panel",
                nav_about_mobile: "About Me", nav_plugins_mobile: "Plugins", nav_wiki_mobile: "Wiki", nav_contact_mobile: "Contact", nav_account_mobile: "My Account", nav_panel_mobile: "My Panel",
                hero_title: "Minecraft Plugins of Exceptional Quality",
                hero_subtitle: "Empowering servers with robust, innovative, and performance-optimized tools.",
                hero_cta: "Explore Plugins",
                feature1_title: "High Performance", feature1_desc: "Highly optimized to not affect your server's TPS.",
                feature2_title: "Easy Configuration", feature2_desc: "Intuitive configuration files and clear documentation.",
                feature3_title: "Reliable Support", feature3_desc: "Fast and effective assistance to resolve any question or issue.",
                plugins_title: "My Creations", plugins_subtitle: "Each plugin is designed with attention to detail and a focus on quality.",
                buy_now_btn: "Buy Now",
                claim_now_btn: "Claim Now",
                free_text: "Free",
                owned_text: "Owned",
                go_to_panel_btn: "Go to Panel",
                no_plugins_title: "No Plugins Yet", no_plugins_desc: "No plugins have been uploaded yet. Check back soon!",
                about_role: "Creator, Coder, and Minecraft Enthusiast",
                about_desc: "Hello! I am a passionate Minecraft plugin developer. What began as a simple curiosity to modify the world of cubes quickly turned into a true calling. My philosophy centers on quality, performance, and innovation.",
                wiki_title: "Wiki & Documentation", wiki_subtitle: "Detailed guides and explanations to get the most out of my plugins.",
                slotmachine_title: "SlotMachine Plugin", slotmachine_desc: "The SlotMachine plugin adds a fully functional and customizable slot machine to your server. It allows players to bet in-game money for a chance to win incredible prizes. It is highly configurable, from winning percentages to the items that can be obtained. Ideal for server economies looking to add an element of luck and fun.",
                contact_title: "Interested? Let's talk.", contact_subtitle: "I am available for custom commissions, support, or any other inquiries.",
                contact_cta: "Contact via Email",
                footer_love: "Made with ❤️ for the Minecraft community."
            }
        };

        const langEsBtn = document.getElementById('lang-es');
        const langEnBtn = document.getElementById('lang-en');
        let currentLang = 'es';

        function setLanguage(lang) {
            currentLang = lang;
            document.documentElement.lang = lang;
            
            // Update button styles
            if (lang === 'es') {
                langEsBtn.classList.add('bg-accent-primary', 'text-bg-primary');
                langEsBtn.classList.remove('text-text-secondary');
                langEnBtn.classList.remove('bg-accent-primary', 'text-bg-primary');
                langEnBtn.classList.add('text-text-secondary');
            } else {
                langEnBtn.classList.add('bg-accent-primary', 'text-bg-primary');
                langEnBtn.classList.remove('text-text-secondary');
                langEsBtn.classList.remove('bg-accent-primary', 'text-bg-primary');
                langEsBtn.classList.add('text-text-secondary');
            }

            // Update text content
            document.querySelectorAll('[data-lang]').forEach(el => {
                const key = el.getAttribute('data-lang');
                if (translations[lang][key]) {
                    el.textContent = translations[lang][key];
                }
            });
        }

        langEsBtn.addEventListener('click', () => setLanguage('es'));
        langEnBtn.addEventListener('click', () => setLanguage('en'));

        // Set initial language
        setLanguage('es');

    </script>
</body>
</html>