<?php
// --- Contenido del Header ---
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

$page_title = "Wiki - RankupIK";
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
        code {
            background-color: var(--bg-secondary);
            color: var(--accent-secondary);
            padding: 0.2em 0.4em;
            margin: 0;
            font-size: 85%;
            border-radius: 6px;
        }
        pre code {
            color: var(--text-primary);
        }
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
                <a href="/infinityweb/" class="text-sm font-semibold hover:text-accent-primary transition" data-lang="nav_home">Inicio</a>
                <a href="/infinityweb/plataforma/panel_usuario.php" class="text-sm font-semibold hover:text-accent-primary transition" data-lang="nav_panel">Mi Panel</a>
                 <div class="flex items-center space-x-1 bg-bg-secondary p-1 rounded-lg border border-border-color">
                    <a href="?lang=es" class="px-3 py-1 text-sm rounded-md transition <?php echo $_SESSION['lang'] === 'es' ? 'bg-accent-primary text-bg-primary font-semibold' : 'text-text-secondary'; ?>">ES</a>
                    <a href="?lang=en" class="px-3 py-1 text-sm rounded-md transition <?php echo $_SESSION['lang'] === 'en' ? 'bg-accent-primary text-bg-primary font-semibold' : 'text-text-secondary'; ?>">EN</a>
                </div>
            </div>
        </nav>
    </header>
    <main class="flex-grow container mx-auto px-6">

        <div class="py-12 md:py-20">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-black tracking-tighter">
                    <span class="gradient-text">RankupIK</span> Wiki
                </h1>
                <p class="text-lg md:text-xl text-text-secondary max-w-3xl mx-auto mt-4" data-lang="wiki_subtitle">
                    La guía definitiva para instalar, configurar y dominar el plugin RankupIK en tu servidor de Minecraft.
                </p>
            </div>

            <div class="space-y-20">
                 <section id="instalacion">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="download-cloud" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_installation_title">Instalación y Dependencias</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p data-lang="installation_intro">Para instalar RankupIK, primero asegúrate de tener las siguientes dependencias instaladas en tu servidor:</p>
                        <ul class="list-disc list-inside space-y-2 pl-2">
                            <li><b class="text-text-primary">LuckPerms</b>: <b class="text-red-400" data-lang="dep_required">Obligatorio.</b> <span data-lang="dep_luckperms">El plugin se basa en LuckPerms para gestionar los rangos de los jugadores.</span></li>
                            <li><b class="text-text-primary">PlaceholderAPI</b>: <b class="text-yellow-400" data-lang="dep_recommended">Recomendado.</b> <span data-lang="dep_papi">Necesario si quieres usar los placeholders del plugin en otros plugins como un scoreboard o un tabulador.</span></li>
                            <li><b class="text-text-primary">MythicMobs</b>: <b class="text-green-400" data-lang="dep_optional">Opcional.</b> <span data-lang="dep_mythicmobs">Solo es necesario si quieres configurar requisitos de matar mobs personalizados de MythicMobs.</span></li>
                        </ul>
                        <p class="pt-2" data-lang="installation_steps">Una vez confirmadas las dependencias, simplemente coloca el archivo <code>RankupIK.jar</code> en la carpeta <code>/plugins</code> de tu servidor y reinícialo. Los archivos de configuración se generarán automáticamente.</p>
                    </div>
                </section>
                
                <section id="caracteristicas">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="sparkles" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_features_title">Características Principales</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <ul class="list-disc list-inside space-y-3 pl-2">
                            <li><b class="text-text-primary" data-lang="feature_stats_title">Progreso por Estadísticas</b>: <span data-lang="feature_stats_desc">Olvídate de los rangos por dinero. Los jugadores ascienden cumpliendo objetivos de juego (minar, construir, luchar, explorar, etc.).</span></li>
                            <li><b class="text-text-primary" data-lang="feature_gui_title">GUIs Interactivas</b>: <span data-lang="feature_gui_desc">Menús intuitivos para que los jugadores vean el camino de rangos, su progreso actual hacia el siguiente rango y gestionen sus títulos.</span></li>
                            <li><b class="text-text-primary" data-lang="feature_afk_title">Sistema Anti-AFK</b>: <span data-lang="feature_afk_desc">Detecta jugadores inactivos para pausar su conteo de tiempo de juego e incluye un sistema CAPTCHA para prevenir trampas con máquinas de AFK.</span></li>
                            <li><b class="text-text-primary" data-lang="feature_titles_title">Títulos Cosméticos</b>: <span data-lang="feature_titles_desc">Recompensa a tus jugadores con sufijos personalizables que pueden desbloquear y activar al cumplir ciertos hitos o mediante permisos.</span></li>
                            <li><b class="text-text-primary" data-lang="feature_config_title">Altamente Configurable</b>: <span data-lang="feature_config_desc">Personaliza cada aspecto, desde los requisitos de cada rango hasta los ítems que se muestran en las GUIs y los mensajes del plugin.</span></li>
                            <li><b class="text-text-primary" data-lang="feature_mm_title">Integración con MythicMobs</b>: <span data-lang="feature_mm_desc">Crea objetivos que requieran matar mobs personalizados de MythicMobs.</span></li>
                        </ul>
                    </div>
                </section>
                
                 <section id="guis">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="layout-template" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_guis_title">Interfaces Gráficas (GUIs)</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-6 text-text-secondary">
                        <div>
                            <h3 class="font-semibold text-xl text-text-primary mb-2" data-lang="gui_ranks_title">GUI de Rangos (`/rankup`)</h3>
                            <p data-lang="gui_ranks_desc">Cuando un jugador nuevo ejecuta <code>/rankup</code>, ve una lista de todos los rangos disponibles. Los rangos se muestran con su estado: <b class="text-green-400" data-lang="status_current">Actual</b>, <b class="text-yellow-400" data-lang="status_next">Siguiente</b>, <b class="text-cyan-400" data-lang="status_unlocked">Desbloqueado</b> o <b class="text-red-400" data-lang="status_locked">Bloqueado</b>. También presenta un botón para comenzar la aventura y empezar a registrar su progreso.</p>
                        </div>
                        <div class="border-t border-border-color pt-6">
                            <h3 class="font-semibold text-xl text-text-primary mb-2" data-lang="gui_progress_title">GUI de Progreso (`/rankup`)</h3>
                            <p data-lang="gui_progress_desc">Una vez que el jugador ha comenzado, <code>/rankup</code> le mostrará la GUI de progreso. Aquí verá todos los requisitos para su siguiente rango, con barras de progreso visuales y porcentajes para cada objetivo. El botón inferior le permite ascender una vez que todos los requisitos están completos.</p>
                        </div>
                        <div class="border-t border-border-color pt-6">
                            <h3 class="font-semibold text-xl text-text-primary mb-2" data-lang="gui_titles_title">GUI de Títulos (`/rankup titles`)</h3>
                            <p data-lang="gui_titles_desc">Este menú permite a los jugadores ver todos los títulos que han desbloqueado. Pueden seleccionar uno para activarlo como sufijo en el chat o desactivar el que tengan activo. Los títulos bloqueados mostrarán los requisitos necesarios para su obtención.</p>
                        </div>
                    </div>
                </section>

                <section id="configuracion">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="file-cog" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_config_title">Guía de Configuración (config.yml)</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p data-lang="config_intro">El archivo <code>config.yml</code> te permite personalizar cada aspecto del plugin. Aquí se detallan las secciones clave:</p>
                        <pre class="bg-bg-primary border border-border-color rounded-lg p-4 text-sm overflow-x-auto"><code>
# Define el camino que los jugadores deben seguir. El orden es fundamental.
rank-order:
  - 'default'
  - 'initiate'
  - 'miner'
  - '...'

# Configuración de cada rango
ranks:
  # El nombre debe coincidir con uno en rank-order
  initiate: 
    gui_item:
      material: 'GRASS_BLOCK'
      name: '&aRango Iniciado'
      lore:
        - '&7El comienzo de tu aventura.'
        - ''
        - '{status}' # Placeholder para el estado del rango
    requirements:
      playtime: 900       # 900 segundos (15 min) de juego
      walked: 1000        # Caminar 1000 bloques
      blocks_mined:
        STONE: 500        # Minar 500 de piedra
        COAL_ORE: 100     # Minar 100 de mena de carbón
      mobs:
        ZOMBIE: 10        # Matar 10 zombies
        mm:SkeletalKnight: 1 # Matar 1 SkeletalKnight de MythicMobs
    commands:
      # Comandos a ejecutar por la consola cuando el jugador asciende.
      - 'lp user {player} parent set initiate'
      - 'broadcast &e{player} &aha comenzado su aventura!'
    # Opcional: define qué estadísticas se resetean para este rango en específico.
    # Si esta sección no existe, se usa el valor de 'stat-reset-behavior'.
    reset_stats_on_promote:
      - 'blocks_mined'
      - 'mobs'

# Títulos cosméticos que los jugadores pueden desbloquear
titles:
  expert_miner:
    name: '&bTítulo: Minero Experto'
    suffix: '&f[&bMinero Experto&f]' # El sufijo que se mostrará
    permission: 'rankupik.titles.miner' # Opcional: se desbloquea con este permiso
    requirement:
      blocks_mined:
        DIAMOND_ORE: 64
    message_unlock: notification_title_expert_miner_unlock # Mensaje al desbloquear
                        </code></pre>
                    </div>
                </section>

                <section id="comandos">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="terminal" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_commands_title">Comandos y Permisos</span></h2>
                    <div class="glass-card rounded-2xl p-8">
                         <p class="mb-6 text-text-secondary" data-lang="commands_intro">El permiso de administrador para los comandos de gestión es <code>rankupik.admin</code>.</p>
                        <div class="divide-y divide-border-color">
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup</b>: <span data-lang="cmd_rankup">Abre la GUI principal.</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup titles</b>: <span data-lang="cmd_titles">Abre el menú de títulos.</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup top &lt;estadística&gt;</b>: <span data-lang="cmd_top">Muestra la tabla de clasificación. (Permiso: <code>rankupik.top</code>)</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup help</b>: <span data-lang="cmd_help">Muestra una lista de todos los comandos.</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup variables</b>: <span data-lang="cmd_variables">Lista todas las variables de requisitos que puedes usar en la config.</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup placeholders</b>: <span data-lang="cmd_placeholders">Muestra todos los placeholders de PlaceholderAPI disponibles.</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-accent-secondary">/rankup reload</b>: <span data-lang="cmd_reload">Recarga la configuración. (Admin)</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-accent-secondary">/rankup force &lt;jugador&gt; &lt;rango&gt;</b>: <span data-lang="cmd_force">Establece a un jugador en un rango específico. (Admin)</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-accent-secondary">/rankup reset &lt;jugador&gt;</b>: <span data-lang="cmd_reset">Borra todos los datos de progreso de un jugador. (Admin)</span></p></div>
                            <div class="py-4"><p><b class="font-mono text-accent-secondary">/rankup setstat &lt;jugador&gt; &lt;stat&gt; &lt;valor&gt;</b>: <span data-lang="cmd_setstat">Asigna un valor a una estadística de un jugador. (Admin)</span></p></div>
                        </div>
                    </div>
                </section>

                <section id="placeholders">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="at-sign" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_placeholders_title">Placeholders</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p data-lang="placeholders_intro">Si tienes PlaceholderAPI, puedes usar los siguientes placeholders en otros plugins. Se dividen en dos categorías:</p>
                        <div>
                            <h3 class="font-semibold text-lg text-text-primary mb-2" data-lang="placeholders_rank_title">Estadísticas de Rango (se reinician)</h3>
                            <p data-lang="placeholders_rank_desc">Estas estadísticas reflejan el progreso del jugador para su rango <b class="text-text-primary">actual</b>. Se reinician según tu configuración.</p>
                        </div>
                         <div class="border-t border-border-color pt-4">
                            <h3 class="font-semibold text-lg text-text-primary mb-2" data-lang="placeholders_global_title">Estadísticas Globales (nunca se reinician)</h3>
                            <p data-lang="placeholders_global_desc">Estas estadísticas acumulan el progreso del jugador a lo largo de <b class="text-text-primary">toda su historia</b> en el servidor.</p>
                        </div>
                         <div class="border-t border-border-color pt-4">
                            <h3 class="font-semibold text-lg text-text-primary mb-2" data-lang="placeholders_other_title">Otros Placeholders</h3>
                             <ul class="list-disc list-inside space-y-1 pl-2 mt-2">
                                <li data-lang="placeholder_suffix"><code>%rankupik_active_title_suffix%</code> - Muestra el sufijo del título activo del jugador.</li>
                             </ul>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <footer class="border-t border-border-color py-8 mt-auto">
        <div class="container mx-auto px-6 text-center text-text-secondary text-sm">
            <p>&copy; <?php echo date("Y"); ?> infinity3113. <span data-lang="footer_rights">Todos los derechos reservados.</span></p>
        </div>
    </footer>
    <script>
        lucide.createIcons();
        
        const translations = {
            es: {
                nav_home: "Inicio",
                nav_panel: "Mi Panel",
                wiki_subtitle: "La guía definitiva para instalar, configurar y dominar el plugin RankupIK en tu servidor de Minecraft.",
                section_installation_title: "Instalación y Dependencias",
                installation_intro: "Para instalar RankupIK, primero asegúrate de tener las siguientes dependencias instaladas en tu servidor:",
                dep_required: "Obligatorio.",
                dep_recommended: "Recomendado.",
                dep_optional: "Opcional.",
                dep_luckperms: "El plugin se basa en LuckPerms para gestionar los rangos de los jugadores.",
                dep_papi: "Necesario si quieres usar los placeholders del plugin en otros plugins como un scoreboard o un tabulador.",
                dep_mythicmobs: "Solo es necesario si quieres configurar requisitos de matar mobs personalizados de MythicMobs.",
                installation_steps: "Una vez confirmadas las dependencias, simplemente coloca el archivo <code>RankupIK.jar</code> en la carpeta <code>/plugins</code> de tu servidor y reinícialo. Los archivos de configuración se generarán automáticamente.",
                section_features_title: "Características Principales",
                feature_stats_title: "Progreso por Estadísticas",
                feature_stats_desc: "Olvídate de los rangos por dinero. Los jugadores ascienden cumpliendo objetivos de juego (minar, construir, luchar, explorar, etc.).",
                feature_gui_title: "GUIs Interactivas",
                feature_gui_desc: "Menús intuitivos para que los jugadores vean el camino de rangos, su progreso actual hacia el siguiente rango y gestionen sus títulos.",
                feature_afk_title: "Sistema Anti-AFK",
                feature_afk_desc: "Detecta jugadores inactivos para pausar su conteo de tiempo de juego e incluye un sistema CAPTCHA para prevenir trampas con máquinas de AFK.",
                feature_titles_title: "Títulos Cosméticos",
                feature_titles_desc: "Recompensa a tus jugadores con sufijos personalizables que pueden desbloquear y activar al cumplir ciertos hitos o mediante permisos.",
                feature_config_title: "Altamente Configurable",
                feature_config_desc: "Personaliza cada aspecto, desde los requisitos de cada rango hasta los ítems que se muestran en las GUIs y los mensajes del plugin.",
                feature_mm_title: "Integración con MythicMobs",
                feature_mm_desc: "Crea objetivos que requieran matar mobs personalizados de MythicMobs.",
                section_guis_title: "Interfaces Gráficas (GUIs)",
                gui_ranks_title: "GUI de Rangos (`/rankup`)",
                gui_ranks_desc: "Cuando un jugador nuevo ejecuta `/rankup`, ve una lista de todos los rangos disponibles. Los rangos se muestran con su estado: ",
                status_current: "Actual",
                status_next: "Siguiente",
                status_unlocked: "Desbloqueado",
                status_locked: "Bloqueado",
                gui_progress_title: "GUI de Progreso (`/rankup`)",
                gui_progress_desc: "Una vez que el jugador ha comenzado, `/rankup` le mostrará la GUI de progreso. Aquí verá todos los requisitos para su siguiente rango, con barras de progreso visuales y porcentajes para cada objetivo. El botón inferior le permite ascender una vez que todos los requisitos están completos.",
                gui_titles_title: "GUI de Títulos (`/rankup titles`)",
                gui_titles_desc: "Este menú permite a los jugadores ver todos los títulos que han desbloqueado. Pueden seleccionar uno para activarlo como sufijo en el chat o desactivar el que tengan activo. Los títulos bloqueados mostrarán los requisitos necesarios para su obtención.",
                section_config_title: "Guía de Configuración (config.yml)",
                config_intro: "El archivo <code>config.yml</code> te permite personalizar cada aspecto del plugin. Aquí se detallan las secciones clave:",
                section_commands_title: "Comandos y Permisos",
                commands_intro: "El permiso de administrador para los comandos de gestión es <code>rankupik.admin</code>.",
                cmd_rankup: "Abre la GUI principal.",
                cmd_titles: "Abre el menú de títulos.",
                cmd_top: "Muestra la tabla de clasificación. (Permiso: <code>rankupik.top</code>)",
                cmd_help: "Muestra una lista de todos los comandos.",
                cmd_variables: "Lista todas las variables de requisitos que puedes usar en la config.",
                cmd_placeholders: "Muestra todos los placeholders de PlaceholderAPI disponibles.",
                cmd_reload: "Recarga la configuración. (Admin)",
                cmd_force: "Establece a un jugador en un rango específico. (Admin)",
                cmd_reset: "Borra todos los datos de progreso de un jugador. (Admin)",
                cmd_setstat: "Asigna un valor a una estadística de un jugador. (Admin)",
                section_placeholders_title: "Placeholders",
                placeholders_intro: "Si tienes PlaceholderAPI, puedes usar los siguientes placeholders en otros plugins. Se dividen en dos categorías:",
                placeholders_rank_title: "Estadísticas de Rango (se reinician)",
                placeholders_rank_desc: "Estas estadísticas reflejan el progreso del jugador para su rango <b>actual</b>. Se reinician según tu configuración.",
                placeholders_global_title: "Estadísticas Globales (nunca se reinician)",
                placeholders_global_desc: "Estas estadísticas acumulan el progreso del jugador a lo largo de <b>toda su historia</b> en el servidor.",
                placeholders_other_title: "Otros Placeholders",
                placeholder_suffix: "<code>%rankupik_active_title_suffix%</code> - Muestra el sufijo del título activo del jugador.",
                footer_rights: "Todos los derechos reservados."
            },
            en: {
                nav_home: "Home",
                nav_panel: "My Panel",
                wiki_subtitle: "The definitive guide to install, configure, and master the RankupIK plugin on your Minecraft server.",
                section_installation_title: "Installation and Dependencies",
                installation_intro: "To install RankupIK, first ensure you have the following dependencies installed on your server:",
                dep_required: "Required.",
                dep_recommended: "Recommended.",
                dep_optional: "Optional.",
                dep_luckperms: "The plugin is based on LuckPerms to manage player ranks.",
                dep_papi: "Necessary if you want to use the plugin's placeholders in other plugins like a scoreboard or a tab list.",
                dep_mythicmobs: "Only necessary if you want to configure custom MythicMobs mob kill requirements.",
                installation_steps: "Once the dependencies are confirmed, simply place the <code>RankupIK.jar</code> file in your server's <code>/plugins</code> folder and restart it. The configuration files will be generated automatically.",
                section_features_title: "Main Features",
                feature_stats_title: "Progression by Statistics",
                feature_stats_desc: "Forget about ranks based on money. Players rank up by completing in-game objectives (mining, building, fighting, exploring, etc.).",
                feature_gui_title: "Interactive GUIs",
                feature_gui_desc: "Intuitive menus for players to see the rank path, their current progress towards the next rank, and manage their titles.",
                feature_afk_title: "Anti-AFK System",
                feature_afk_desc: "Detects inactive players to pause their playtime count and includes a CAPTCHA system to prevent cheating with AFK machines.",
                feature_titles_title: "Cosmetic Titles",
                feature_titles_desc: "Reward your players with customizable suffixes that they can unlock and activate upon reaching certain milestones or through permissions.",
                feature_config_title: "Highly Configurable",
                feature_config_desc: "Customize every aspect, from the requirements for each rank to the items displayed in the GUIs and the plugin's messages.",
                feature_mm_title: "MythicMobs Integration",
                feature_mm_desc: "Create objectives that require killing custom mobs from MythicMobs.",
                section_guis_title: "Graphical User Interfaces (GUIs)",
                gui_ranks_title: "Ranks GUI (`/rankup`)",
                gui_ranks_desc: "When a new player runs `/rankup`, they see a list of all available ranks. The ranks are displayed with their status: ",
                status_current: "Current",
                status_next: "Next",
                status_unlocked: "Unlocked",
                status_locked: "Locked",
                gui_progress_title: "Progress GUI (`/rankup`)",
                gui_progress_desc: "Once the player has started, `/rankup` will show them the progress GUI. Here they will see all the requirements for their next rank, with visual progress bars and percentages for each objective. The bottom button allows them to rank up once all requirements are complete.",
                gui_titles_title: "Titles GUI (`/rankup titles`)",
                gui_titles_desc: "This menu allows players to see all the titles they have unlocked. They can select one to activate it as a suffix in the chat or deactivate the current one. Locked titles will show the necessary requirements to obtain them.",
                section_config_title: "Configuration Guide (config.yml)",
                config_intro: "The <code>config.yml</code> file allows you to customize every aspect of the plugin. Here are the key sections:",
                section_commands_title: "Commands and Permissions",
                commands_intro: "The administrator permission for management commands is <code>rankupik.admin</code>.",
                cmd_rankup: "Opens the main GUI.",
                cmd_titles: "Opens the titles menu.",
                cmd_top: "Displays the leaderboard. (Permission: <code>rankupik.top</code>)",
                cmd_help: "Displays a list of all commands.",
                cmd_variables: "Lists all the requirement variables you can use in the config.",
                cmd_placeholders: "Shows all available PlaceholderAPI placeholders.",
                cmd_reload: "Reloads the configuration. (Admin)",
                cmd_force: "Sets a player to a specific rank. (Admin)",
                cmd_reset: "Deletes all progress data for a player. (Admin)",
                cmd_setstat: "Assigns a value to a player's statistic. (Admin)",
                section_placeholders_title: "Placeholders",
                placeholders_intro: "If you have PlaceholderAPI, you can use the following placeholders in other plugins. They are divided into two categories:",
                placeholders_rank_title: "Rank Statistics (resettable)",
                placeholders_rank_desc: "These statistics reflect the player's progress for their <b>current</b> rank. They are reset according to your configuration.",
                placeholders_global_title: "Global Statistics (never reset)",
                placeholders_global_desc: "These statistics accumulate the player's progress throughout their <b>entire history</b> on the server.",
                placeholders_other_title: "Other Placeholders",
                placeholder_suffix: "<code>%rankupik_active_title_suffix%</code> - Displays the player's active title suffix.",
                footer_rights: "All rights reserved."
            }
        };

        function setLanguage(lang) {
            document.querySelectorAll('[data-lang]').forEach(el => {
                const key = el.getAttribute('data-lang');
                if (translations[lang] && translations[lang][key]) {
                    el.innerHTML = translations[lang][key];
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const currentLang = document.documentElement.lang;
            setLanguage(currentLang);
        });

    </script>
</body>
</html>