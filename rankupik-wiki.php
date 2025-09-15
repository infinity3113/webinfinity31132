<?php
// --- Contenido del Header ---
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'es';
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
                <a href="/infinityweb/" class="text-sm font-semibold hover:text-accent-primary transition">Inicio</a>
                <a href="/infinityweb/plataforma/panel_usuario.php" class="text-sm font-semibold hover:text-accent-primary transition">Mi Panel</a>
            </div>
        </nav>
    </header>
    <main class="flex-grow container mx-auto px-6">

        <div class="py-12 md:py-20">
            <div class="text-center mb-16">
                <h1 class="text-4xl md:text-6xl font-black tracking-tighter">
                    <span class="gradient-text">RankupIK</span> Wiki
                </h1>
                <p class="text-lg md:text-xl text-text-secondary max-w-3xl mx-auto mt-4">
                    La guía definitiva para instalar, configurar y dominar el plugin RankupIK en tu servidor de Minecraft.
                </p>
            </div>

            <div class="space-y-20">
                 <section id="instalacion">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="download-cloud" class="w-7 h-7 text-accent-primary"></i>Instalación y Dependencias</h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p>Para instalar RankupIK, primero asegúrate de tener las siguientes dependencias instaladas en tu servidor:</p>
                        <ul class="list-disc list-inside space-y-2 pl-2">
                            <li><b class="text-text-primary">LuckPerms</b>: <b class="text-red-400">Obligatorio.</b> El plugin se basa en LuckPerms para gestionar los rangos de los jugadores.</li>
                            <li><b class="text-text-primary">PlaceholderAPI</b>: <b class="text-yellow-400">Recomendado.</b> Necesario si quieres usar los placeholders del plugin en otros plugins como un scoreboard o un tabulador.</li>
                            <li><b class="text-text-primary">MythicMobs</b>: <b class="text-green-400">Opcional.</b> Solo es necesario si quieres configurar requisitos de matar mobs personalizados de MythicMobs.</li>
                        </ul>
                        <p class="pt-2">Una vez confirmadas las dependencias, simplemente coloca el archivo <code>RankupIK.jar</code> en la carpeta <code>/plugins</code> de tu servidor y reinícialo. Los archivos de configuración se generarán automáticamente.</p>
                    </div>
                </section>
                
                <section id="caracteristicas">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="sparkles" class="w-7 h-7 text-accent-primary"></i>Características Principales</h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <ul class="list-disc list-inside space-y-3 pl-2">
                            <li><b class="text-text-primary">Progreso por Estadísticas</b>: Olvídate de los rangos por dinero. Los jugadores ascienden cumpliendo objetivos de juego (minar, construir, luchar, explorar, etc.).</li>
                            <li><b class="text-text-primary">GUIs Interactivas</b>: Menús intuitivos para que los jugadores vean el camino de rangos, su progreso actual hacia el siguiente rango y gestionen sus títulos.</li>
                            <li><b class="text-text-primary">Sistema Anti-AFK</b>: Detecta jugadores inactivos para pausar su conteo de tiempo de juego e incluye un sistema CAPTCHA para prevenir trampas con máquinas de AFK.</li>
                            <li><b class="text-text-primary">Títulos Cosméticos</b>: Recompensa a tus jugadores con sufijos personalizables que pueden desbloquear y activar al cumplir ciertos hitos o mediante permisos.</li>
                            <li><b class="text-text-primary">Altamente Configurable</b>: Personaliza cada aspecto, desde los requisitos de cada rango hasta los ítems que se muestran en las GUIs y los mensajes del plugin.</li>
                            <li><b class="text-text-primary">Integración con MythicMobs</b>: Crea objetivos que requieran matar mobs personalizados de MythicMobs.</li>
                        </ul>
                    </div>
                </section>
                
                 <section id="guis">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="layout-template" class="w-7 h-7 text-accent-primary"></i>Interfaces Gráficas (GUIs)</h2>
                    <div class="glass-card rounded-2xl p-8 space-y-6 text-text-secondary">
                        <div>
                            <h3 class="font-semibold text-xl text-text-primary mb-2">GUI de Rangos (`/rankup`)</h3>
                            <p>Cuando un jugador nuevo ejecuta <code>/rankup</code>, ve una lista de todos los rangos disponibles. Los rangos se muestran con su estado: <b class="text-green-400">Actual</b>, <b class="text-yellow-400">Siguiente</b>, <b class="text-cyan-400">Desbloqueado</b> o <b class="text-red-400">Bloqueado</b>. También presenta un botón para comenzar la aventura y empezar a registrar su progreso.</p>
                            <p class="text-center mt-4"></p>
                        </div>
                        <div class="border-t border-border-color pt-6">
                            <h3 class="font-semibold text-xl text-text-primary mb-2">GUI de Progreso (`/rankup`)</h3>
                            <p>Una vez que el jugador ha comenzado, <code>/rankup</code> le mostrará la GUI de progreso. Aquí verá todos los requisitos para su siguiente rango, con barras de progreso visuales y porcentajes para cada objetivo. El botón inferior le permite ascender una vez que todos los requisitos están completos.</p>
                            <p class="text-center mt-4"></p>
                        </div>
                        <div class="border-t border-border-color pt-6">
                            <h3 class="font-semibold text-xl text-text-primary mb-2">GUI de Títulos (`/rankup titles`)</h3>
                            <p>Este menú permite a los jugadores ver todos los títulos que han desbloqueado. Pueden seleccionar uno para activarlo como sufijo en el chat o desactivar el que tengan activo. Los títulos bloqueados mostrarán los requisitos necesarios para su obtención.</p>
                             <p class="text-center mt-4"></p>
                        </div>
                    </div>
                </section>

                <section id="configuracion">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="file-cog" class="w-7 h-7 text-accent-primary"></i>Guía de Configuración (config.yml)</h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p>El archivo <code>config.yml</code> te permite personalizar cada aspecto del plugin. Aquí se detallan las secciones clave:</p>
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
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="terminal" class="w-7 h-7 text-accent-primary"></i>Comandos y Permisos</h2>
                    <div class="glass-card rounded-2xl p-8">
                         <p class="mb-6 text-text-secondary">El permiso de administrador para los comandos de gestión es <code>rankupik.admin</code>.</p>
                        <div class="divide-y divide-border-color">
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup</b>: Abre la GUI principal.</p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup titles</b>: Abre el menú de títulos.</p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup top &lt;estadística&gt;</b>: Muestra la tabla de clasificación. (Permiso: <code>rankupik.top</code>)</p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup help</b>: Muestra una lista de todos los comandos.</p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup variables</b>: Lista todas las variables de requisitos que puedes usar en la config.</p></div>
                            <div class="py-4"><p><b class="font-mono text-text-primary">/rankup placeholders</b>: Muestra todos los placeholders de PlaceholderAPI disponibles.</p></div>
                            <div class="py-4"><p><b class="font-mono text-accent-secondary">/rankup reload</b>: Recarga la configuración. (Admin)</p></div>
                            <div class="py-4"><p><b class="font-mono text-accent-secondary">/rankup force &lt;jugador&gt; &lt;rango&gt;</b>: Establece a un jugador en un rango específico. (Admin)</p></div>
                            <div class="py-4"><p><b class="font-mono text-accent-secondary">/rankup reset &lt;jugador&gt;</b>: Borra todos los datos de progreso de un jugador. (Admin)</p></div>
                            <div class="py-4"><p><b class="font-mono text-accent-secondary">/rankup setstat &lt;jugador&gt; &lt;stat&gt; &lt;valor&gt;</b>: Asigna un valor a una estadística de un jugador. (Admin)</p></div>
                        </div>
                    </div>
                </section>

                <section id="placeholders">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="at-sign" class="w-7 h-7 text-accent-primary"></i>Placeholders</h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p>Si tienes PlaceholderAPI, puedes usar los siguientes placeholders en otros plugins. Se dividen en dos categorías:</p>
                        <div>
                            <h3 class="font-semibold text-lg text-text-primary mb-2">Estadísticas de Rango (se reinician)</h3>
                            <p>Estas estadísticas reflejan el progreso del jugador para su rango <b class="text-text-primary">actual</b>. Se reinician según tu configuración.</p>
                            <ul class="list-disc list-inside space-y-1 pl-2 mt-2">
                                <li><code>%rankupik_playtime_seconds%</code> - Tiempo de juego en segundos.</li>
                                <li><code>%rankupik_playtime_formatted%</code> - Tiempo de juego en formato D/H/M/S.</li>
                                <li><code>%rankupik_blocks_mined_&lt;MATERIAL&gt;%</code> - Bloques minados de un tipo específico.</li>
                                <li><code>%rankupik_mobs_killed_&lt;MOB&gt;%</code> - Mobs asesinados de un tipo específico.</li>
                                <li>Y muchos más... usa <code>/rankup placeholders</code> para ver la lista completa.</li>
                            </ul>
                        </div>
                         <div class="border-t border-border-color pt-4">
                            <h3 class="font-semibold text-lg text-text-primary mb-2">Estadísticas Globales (nunca se reinician)</h3>
                            <p>Estas estadísticas acumulan el progreso del jugador a lo largo de <b class="text-text-primary">toda su historia</b> en el servidor.</p>
                            <ul class="list-disc list-inside space-y-1 pl-2 mt-2">
                                <li><code>%rankupik_global_playtime_seconds%</code></li>
                                <li><code>%rankupik_global_playtime_formatted%</code></li>
                                <li><code>%rankupik_global_blocks_mined_&lt;MATERIAL&gt;%</code></li>
                                <li>...y todos los demás con el prefijo <code>global_</code>.</li>
                            </ul>
                        </div>
                         <div class="border-t border-border-color pt-4">
                            <h3 class="font-semibold text-lg text-text-primary mb-2">Otros Placeholders</h3>
                             <ul class="list-disc list-inside space-y-1 pl-2 mt-2">
                                <li><code>%rankupik_active_title_suffix%</code> - Muestra el sufijo del título activo del jugador.</li>
                             </ul>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
    <footer class="border-t border-border-color py-8 mt-auto">
        <div class="container mx-auto px-6 text-center text-text-secondary text-sm">
            <p>&copy; <?php echo date("Y"); ?> infinity3113. Todos los derechos reservados.</p>
        </div>
    </footer>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>