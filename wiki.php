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
$page_title = "Wiki - SlotMachine";
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
        input, textarea { color: var(--text-primary); }
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: var(--text-primary) !important;
            -webkit-box-shadow: 0 0 0 30px var(--bg-secondary) inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        /* --- Estilos para la Imagen Clickeable --- */
        .clickable-image {
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }
        .clickable-image:hover {
            transform: scale(1.03);
        }
        .image-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.9);
        }
        .image-modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }
        .image-modal-close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }
        .image-modal-close:hover,
        .image-modal-close:focus {
            color: #bbb;
            text-decoration: none;
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
                <a href="/infinityweb/#about" class="text-sm font-semibold hover:text-accent-primary transition" data-lang="nav_about">Sobre Mí</a>
                <a href="/infinityweb/plataforma/panel_usuario.php" class="text-sm font-semibold hover:text-accent-primary transition" data-lang="my_panel">Mi Panel</a>
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
                    <span class="gradient-text">SlotMachine</span> Wiki
                </h1>
                <p class="text-lg md:text-xl text-text-secondary max-w-3xl mx-auto mt-4" data-lang="wiki_main_subtitle">
                    La guía definitiva para instalar, configurar y dominar el plugin SlotMachine en tu servidor de Minecraft.
                </p>
            </div>

            <div class="space-y-20">
                 <section id="instalacion">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="download-cloud" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_installation">Instalación</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p data-lang="installation_intro">Para instalar SlotMachine, asegúrate de cumplir con los siguientes requisitos y sigue estos pasos:</p>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-lg text-text-primary mb-2" data-lang="installation_reqs_title">Dependencias Requeridas:</h3>
                                <ul class="list-disc list-inside space-y-1 pl-2">
                                    <li><a href="https://www.spigotmc.org/resources/vault.34315/" target="_blank" class="font-medium text-accent-primary hover:underline">Vault</a>: <span data-lang="installation_req_vault">Para la gestión de la economía.</span></li>
                                    <li><a href="https://www.spigotmc.org/resources/decentholograms.96927/" target="_blank" class="font-medium text-accent-primary hover:underline">DecentHolograms</a>: <span data-lang="installation_req_dh">Para mostrar el pozo del Jackpot.</span></li>
                                    <li data-lang="installation_req_econ">Un plugin de economía compatible con Vault (Ej: EssentialsX).</li>
                                </ul>
                            </div>
                            <div>
                                <h3 class="font-semibold text-lg text-text-primary mb-2" data-lang="installation_steps_title">Pasos de Instalación:</h3>
                                <ol class="list-decimal list-inside space-y-1 pl-2">
                                    <li data-lang="installation_step1">Descarga la última versión del plugin <a href="https://github.com/infinity3113/SlotMachine" target="_blank" class="font-medium text-accent-primary hover:underline">desde GitHub</a>.</li>
                                    <li data-lang="installation_step2">Coloca el archivo <code>SlotMachine.jar</code> en la carpeta <code>/plugins</code> de tu servidor.</li>
                                    <li data-lang="installation_step3">Asegúrate de tener todas las dependencias en la misma carpeta.</li>
                                    <li data-lang="installation_step4">Inicia o reinicia tu servidor para que se generen los archivos de configuración.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section id="creacion">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="hammer" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_creation">Creación de una Máquina</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p data-lang="creation_intro">Crear una máquina es un proceso interactivo. Primero, construye la estructura física:</p>
                        <div class="text-center p-4 bg-bg-primary rounded-lg border border-border-color">
                            <img src="img/slotmachine_structure.png" alt="Estructura de la máquina tragamonedas" class="clickable-image mx-auto rounded-md border border-border-color max-w-sm h-auto">
                            <p class="text-xs text-text-secondary mt-2" data-lang="creation_img_caption">Estructura base: Una Caja de Música (Jukebox) debajo y 3 Marcos (Item Frames) para la ruleta, lo mejor es que puedes hacer el diseño que tu quieras con tal y tenga la caja y los 3 marcos.</p>
                        </div>
                        <p data-lang="creation_steps_intro">Una vez construida, sigue estos pasos:</p>
                        <ol class="list-decimal list-inside space-y-3 pl-2">
                            <li data-lang="creation_step1">Usa el comando <code>/slot create &lt;nombre&gt;</code>. Por ejemplo: <code>/slot create principal</code>.</li>
                            <li data-lang="creation_step2"><strong>Paso 1:</strong> Haz clic derecho sobre la <strong>Caja de Música (Jukebox)</strong> que será la base de tu máquina.</li>
                            <li data-lang="creation_step3"><strong>Paso 2:</strong> Haz clic derecho, en orden de izquierda a derecha, sobre los <strong>3 Marcos (Item Frames)</strong> que usarás como rodillos.</li>
                            <li data-lang="creation_step4">¡Listo! La máquina se creará y guardará automáticamente. El holograma del Jackpot aparecerá si está activado.</li>
                        </ol>
                        <div class="text-center p-4 mt-4 bg-bg-primary rounded-lg border border-border-color">
                             <video src="img/slotmachine_spinning.mp4" autoplay loop muted playsinline class="mx-auto rounded-md border border-border-color max-w-sm h-auto"></video>
                            <p class="text-xs text-text-secondary mt-2" data-lang="creation_gif_caption">¡La máquina está lista para ser usada!</p>
                        </div>
                    </div>
                </section>

                 <section id="carteles">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="sign-post" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_signs">Creación de Carteles de Compra</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p data-lang="signs_intro">Puedes crear carteles para que los jugadores compren fichas directamente. Para crear uno, coloca un cartel y escribe lo siguiente en cada línea:</p>
                        <div class="grid md:grid-cols-2 gap-6 items-center">
                            <div class="space-y-2">
                                <p><strong><span data-lang="signs_line">Línea 1:</span></strong> <code>[Tragamonedas]</code> <span data-lang="or">o</span> <code>[Slots]</code></p>
                                <p><strong><span data-lang="signs_line">Línea 2:</span></strong> <span data-lang="signs_line2_auto">(se rellenará automáticamente)</span></p>
                                <p><strong><span data-lang="signs_line">Línea 3:</span></strong> <span data-lang="signs_price">El precio por cada ficha (ej: <code>150.5</code>)</span></p>
                                <p><strong><span data-lang="signs_line">Línea 4:</span></strong> <span data-lang="signs_line4_empty">(déjala en blanco)</span></p>
                            </div>
                            <div class="text-center p-4 bg-bg-primary rounded-lg border border-border-color">
                                 <img src="img/slotmachine_sign.png" alt="Cartel de compra de fichas" class="clickable-image mx-auto rounded-md border border-border-color max-w-sm h-auto">
                                <p class="text-xs text-text-secondary mt-2" data-lang="signs_img_caption">El plugin formateará el cartel con colores automáticamente.</p>
                            </div>
                        </div>
                        <p class="!mt-6" data-lang="signs_permission">Para crear un cartel, necesitas el permiso <code>slotmachine.sign.create</code>. Los jugadores podrán usarlo para abrir un menú de compra interactivo.</p>
                    </div>
                </section>
                
                 <section id="configuracion">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="file-cog" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_config">Archivo de Configuración (config.yml)</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p data-lang="config_intro">El archivo <code>config.yml</code> te permite personalizar cada aspecto del plugin. Aquí se detalla cada sección:</p>
                        <pre class="bg-bg-primary border border-border-color rounded-lg p-4 text-sm overflow-x-auto"><code>
# Idioma del plugin. Cambia a "es" para español o "en" para inglés.
language: "es"

machine_settings:
  # Costo en fichas para cada jugada.
  play_cost: 1
  # Valor que cada ficha aporta al pozo del Jackpot.
  coin_value_for_jackpot: 50.0
  # Configura la duración y velocidad de la animación de giro.
  spin_duration:
    base_ticks: 60           # Duración base del giro (20 ticks = 1 segundo).
    reel_delay_ticks: 20     # Retraso entre la detención de cada rodillo.
    extra_random_ticks: 20   # Variación aleatoria para que no duren siempre lo mismo.
    timeout_seconds: 15      # Tiempo máximo de seguridad por si una máquina se atasca.

jackpot:
  # Activa o desactiva el sistema de Jackpot y su holograma.
  enabled: true
  # Cantidad con la que inicia el pozo del Jackpot al crearse o ganarse.
  starting_amount: 500.0

# Define rangos de descuento para la compra de fichas.
purchase_discounts:
  vip1:
    permission: "slotmachine.discount.vip1" # Permiso necesario.
    percentage: 10                           # Porcentaje de descuento.
  vip2:
    permission: "slotmachine.discount.vip2"
    percentage: 25

# Personaliza los sonidos del plugin.
sounds:
  spin: "BLOCK_NOTE_BLOCK_PLING"           # Sonido al girar.
  win: "ENTITY_PLAYER_LEVELUP"             # Sonido al ganar un premio normal.
  lose: "ENTITY_VILLAGER_NO"               # Sonido al no ganar nada.
  coin_insert: "ENTITY_ITEM_PICKUP"        # Sonido al usar una ficha.
  jackpot_win: "UI_TOAST_CHALLENGE_COMPLETE" # Sonido especial al ganar el Jackpot.
  gui_click: "UI_BUTTON_CLICK"             # Sonido en la interfaz de compra.

# Define los ítems que aparecen en la ruleta y su probabilidad.
# Un número más alto significa que aparecerá más a menudo.
roulette_items:
  CHERRY_SAPLING: 60
  COAL: 50
  REDSTONE: 40
  LAPIS_LAZULI: 35
  IRON_INGOT: 25
  GOLD_INGOT: 15
  EMERALD: 8
  DIAMOND: 3

# Define los premios basados en combinaciones.
prizes:
  jackpot_emerald:
    reward: 5000.0 # Cantidad de dinero que se gana.
  gold_win:
    reward: 1000.0
  iron_win:
    reward: 500.0
  two_diamonds:
    reward: 250.0
  two_emeralds:
    reward: 100.0
                        </code></pre>
                    </div>
                </section>

                <section id="comandos">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="terminal" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_commands">Comandos y Permisos</span></h2>
                    <div class="glass-card rounded-2xl p-8">
                        <p class="mb-6 text-text-secondary" data-lang="commands_intro">El comando principal es <code>/slot</code>, con alias <code>/slots</code> y <code>/tragamonedas</code>. Todos los comandos de administración requieren el permiso <code>slotmachine.admin</code>.</p>
                        <div class="divide-y divide-border-color">
                            <div class="py-4">
                                <p class="font-bold text-lg text-text-primary">/slot create &lt;nombre&gt;</p>
                                <p class="text-text-secondary mt-1" data-lang="command_create">Inicia el proceso para crear una nueva máquina con el nombre especificado.</p>
                            </div>
                            <div class="py-4">
                                <p class="font-bold text-lg text-text-primary">/slot delete &lt;nombre&gt;</p>
                                <p class="text-text-secondary mt-1" data-lang="command_delete">Elimina permanentemente una máquina tragamonedas existente.</p>
                            </div>
                            <div class="py-4">
                                <p class="font-bold text-lg text-text-primary">/slot getcoin [cantidad]</p>
                                <p class="text-text-secondary mt-1" data-lang="command_getcoin">Te da la cantidad especificada de fichas de casino. Por defecto es 1.</p>
                            </div>
                            <div class="py-4">
                                <p class="font-bold text-lg text-text-primary">/slot reload</p>
                                <p class="text-text-secondary mt-1" data-lang="command_reload">Recarga todos los archivos de configuración del plugin.</p>
                            </div>
                            <div class="py-4">
                                <p class="font-bold text-lg text-text-primary">/slot help</p>
                                <p class="text-text-secondary mt-1" data-lang="command_help">Muestra un mensaje de ayuda con todos los comandos disponibles.</p>
                            </div>
                            <div class="py-4">
                                <p class="font-bold text-lg text-text-primary">/slot ver</p>
                                <p class="text-text-secondary mt-1" data-lang="command_ver">Muestra la versión actual del plugin y su autor.</p>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold mt-8 mb-4 border-t border-border-color pt-6" data-lang="permissions_title">Permisos Adicionales</h3>
                        <div class="divide-y divide-border-color">
                            <div class="py-3">
                                <p class="font-mono text-sm bg-bg-primary px-2 py-1 rounded-md inline-block">slotmachine.use</p>
                                <p class="text-text-secondary mt-1" data-lang="permission_use">Permite a los jugadores usar las máquinas tragamonedas. Otorgado por defecto.</p>
                            </div>
                            <div class="py-3">
                                <p class="font-mono text-sm bg-bg-primary px-2 py-1 rounded-md inline-block">slotmachine.sign.create</p>
                                <p class="text-text-secondary mt-1" data-lang="permission_sign_create">Permite crear carteles de venta de fichas. Por defecto para OPs.</p>
                            </div>
                            <div class="py-3">
                                <p class="font-mono text-sm bg-bg-primary px-2 py-1 rounded-md inline-block">slotmachine.sign.use</p>
                                <p class="text-text-secondary mt-1" data-lang="permission_sign_use">Permite usar los carteles para comprar fichas. Otorgado por defecto.</p>
                            </div>
                            <div class="py-3">
                                <p class="font-mono text-sm bg-bg-primary px-2 py-1 rounded-md inline-block">slotmachine.discount.*</p>
                                <p class="text-text-secondary mt-1" data-lang="permission_discount">Permisos para descuentos definidos en <code>config.yml</code> (ej. <code>slotmachine.discount.vip1</code>).</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="mensajes">
                    <h2 class="text-3xl font-bold border-b-2 border-border-color pb-3 mb-6 flex items-center gap-3"><i data-lucide="message-square-plus" class="w-7 h-7 text-accent-primary"></i><span data-lang="section_messages">Personalización de Mensajes</span></h2>
                    <div class="glass-card rounded-2xl p-8 space-y-4 text-text-secondary">
                        <p data-lang="messages_intro">Puedes traducir y personalizar casi todos los mensajes del plugin editando los archivos en la carpeta <code>/lang/</code>. El plugin incluye <code>en.yml</code> (inglés) y <code>es.yml</code> (español) por defecto.</p>
                        <p data-lang="messages_prizes">Para definir las combinaciones ganadoras, debes editar el archivo de idioma (ej. <code>es.yml</code>) en la sección <code>prizes</code> y <code>jackpot</code>:</p>
                        <pre class="bg-bg-primary border border-border-color rounded-lg p-4 text-sm overflow-x-auto"><code>
# Define la combinación para el premio mayor.
jackpot:
  combination: "DIAMOND,DIAMOND,DIAMOND"

# Define las combinaciones para los premios normales.
# El nombre debe coincidir con el de config.yml
prizes:
  jackpot_emerald:
    combination: "EMERALD,EMERALD,EMERALD"
  gold_win:
    combination: "GOLD_INGOT,GOLD_INGOT,GOLD_INGOT"
  iron_win:
    combination: "IRON_INGOT,IRON_INGOT,IRON_INGOT"
  # Puedes usar "ANY" como comodín para cualquier ítem.
  two_diamonds:
    combination: "DIAMOND,DIAMOND,ANY"
  two_emeralds:
    combination: "EMERALD,EMERALD,ANY"
                        </code></pre>
                    </div>
                </section>
            </div>
        </div>

    </main>

    <div id="imageModal" class="image-modal">
        <span class="image-modal-close">&times;</span>
        <img class="image-modal-content" id="modalImage">
    </div>

    <footer class="border-t border-border-color py-8 mt-auto">
        <div class="container mx-auto px-6 text-center text-text-secondary text-sm">
            <p>&copy; <?php echo date("Y"); ?> infinity3113. <span data-lang="rights_reserved">Todos los derechos reservados.</span></p>
        </div>
    </footer>
    <script>
        lucide.createIcons();

        const translations = {
            es: {
                nav_about: "Sobre Mí",
                my_panel: "Mi Panel",
                rights_reserved: "Todos los derechos reservados.",
                wiki_main_subtitle: "La guía definitiva para instalar, configurar y dominar el plugin SlotMachine en tu servidor de Minecraft.",
                section_installation: "Instalación",
                installation_intro: "Para instalar SlotMachine, asegúrate de cumplir con los siguientes requisitos y sigue estos pasos:",
                installation_reqs_title: "Dependencias Requeridas:",
                installation_req_vault: "Para la gestión de la economía.",
                installation_req_dh: "Para mostrar el pozo del Jackpot.",
                installation_req_econ: "Un plugin de economía compatible con Vault (Ej: EssentialsX).",
                installation_steps_title: "Pasos de Instalación:",
                installation_step1: "Descarga la última versión del plugin desde GitHub.",
                installation_step2: "Coloca el archivo SlotMachine.jar en la carpeta /plugins de tu servidor.",
                installation_step3: "Asegúrate de tener todas las dependencias en la misma carpeta.",
                installation_step4: "Inicia o reinicia tu servidor para que se generen los archivos de configuración.",
                section_creation: "Creación de una Máquina",
                creation_intro: "Crear una máquina es un proceso interactivo. Primero, construye la estructura física:",
                creation_img_caption: "Estructura base: Una Caja de Música (Jukebox) debajo y 3 Marcos (Item Frames) para la ruleta, lo mejor es que puedes hacer el diseño que tu quieras con tal y tenga la caja y los 3 marcos.",
                creation_steps_intro: "Una vez construida, sigue estos pasos:",
                creation_step1: "Usa el comando /slot create <nombre>. Por ejemplo: /slot create principal.",
                creation_step2: "Paso 1: Haz clic derecho sobre la Caja de Música (Jukebox) que será la base de tu máquina.",
                creation_step3: "Paso 2: Haz clic derecho, en orden de izquierda a derecha, sobre los 3 Marcos (Item Frames) que usarás como rodillos.",
                creation_step4: "¡Listo! La máquina se creará y guardará automáticamente. El holograma del Jackpot aparecerá si está activado.",
                img_placeholder_spinning: "GIF: Máquina funcionando",
                creation_gif_caption: "¡La máquina está lista para ser usada!",
                section_signs: "Creación de Carteles de Compra",
                signs_intro: "Puedes crear carteles para que los jugadores compren fichas directamente. Para crear uno, coloca un cartel y escribe lo siguiente en cada línea:",
                signs_line: "Línea",
                or: "o",
                signs_line2_auto: "(se rellenará automáticamente)",
                signs_price: "El precio por cada ficha (ej: 150.5)",
                signs_line4_empty: "(déjala en blanco)",
                img_placeholder_sign: "IMAGEN: Cartel de compra",
                signs_img_caption: "El plugin formateará el cartel con colores automáticamente.",
                signs_permission: "Para crear un cartel, necesitas el permiso slotmachine.sign.create. Los jugadores podrán usarlo para abrir un menú de compra interactivo.",
                section_config: "Archivo de Configuración (config.yml)",
                config_intro: "El archivo config.yml te permite personalizar cada aspecto del plugin. Aquí se detalla cada sección:",
                section_commands: "Comandos y Permisos",
                commands_intro: "El comando principal es /slot, con alias /slots y /tragamonedas. Todos los comandos de administración requieren el permiso slotmachine.admin.",
                command_create: "Inicia el proceso para crear una nueva máquina con el nombre especificado.",
                command_delete: "Elimina permanentemente una máquina tragamonedas existente.",
                command_getcoin: "Te da la cantidad especificada de fichas de casino. Por defecto es 1.",
                command_reload: "Recarga todos los archivos de configuración del plugin.",
                command_help: "Muestra un mensaje de ayuda con todos los comandos disponibles.",
                command_ver: "Muestra la versión actual del plugin y su autor.",
                permissions_title: "Permisos Adicionales",
                permission_use: "Permite a los jugadores usar las máquinas tragamonedas. Otorgado por defecto.",
                permission_sign_create: "Permite crear carteles de venta de fichas. Por defecto para OPs.",
                permission_sign_use: "Permite usar los carteles para comprar fichas. Otorgado por defecto.",
                permission_discount: "Permisos para descuentos definidos en config.yml (ej. slotmachine.discount.vip1).",
                section_messages: "Personalización de Mensajes",
                messages_intro: "Puedes traducir y personalizar casi todos los mensajes del plugin editando los archivos en la carpeta /lang/. El plugin incluye en.yml (inglés) y es.yml (español) por defecto.",
                messages_prizes: "Para definir las combinaciones ganadoras, debes editar el archivo de idioma (ej. es.yml) en la sección prizes y jackpot:",
            },
            en: {
                nav_about: "About Me",
                my_panel: "My Panel",
                rights_reserved: "All rights reserved.",
                wiki_main_subtitle: "The definitive guide to install, configure, and master the SlotMachine plugin on your Minecraft server.",
                section_installation: "Installation",
                installation_intro: "To install SlotMachine, make sure you meet the following requirements and follow these steps:",
                installation_reqs_title: "Required Dependencies:",
                installation_req_vault: "For economy management.",
                installation_req_dh: "To display the Jackpot pool.",
                installation_req_econ: "A Vault-compatible economy plugin (e.g., EssentialsX).",
                installation_steps_title: "Installation Steps:",
                installation_step1: "Download the latest version of the plugin from GitHub.",
                installation_step2: "Place the SlotMachine.jar file in your server's /plugins folder.",
                installation_step3: "Make sure you have all dependencies in the same folder.",
                installation_step4: "Start or restart your server to generate the configuration files.",
                section_creation: "Creating a Machine",
                creation_intro: "Creating a machine is an interactive process. First, build the physical structure:",
                creation_img_caption: "Base structure: A Music Box (Jukebox) underneath and 3 Frames (Item Frames) for the roulette, the best thing is that you can make any design you want as long as it has the box and the 3 frames.",
                creation_steps_intro: "Once built, follow these steps:",
                creation_step1: "Use the command /slot create <name>. For example: /slot create main.",
                creation_step2: "Step 1: Right-click on the Jukebox that will be the base of your machine.",
                creation_step3: "Step 2: Right-click, in order from left to right, on the 3 Item Frames you will use as reels.",
                creation_step4: "Done! The machine will be created and saved automatically. The Jackpot hologram will appear if enabled.",
                img_placeholder_spinning: "GIF: Machine spinning",
                creation_gif_caption: "The machine is ready to be used!",
                section_signs: "Creating Buy Signs",
                signs_intro: "You can create signs for players to buy tokens directly. To create one, place a sign and write the following on each line:",
                signs_line: "Line",
                or: "or",
                signs_line2_auto: "(will be auto-filled)",
                signs_price: "The price per token (e.g., 150.5)",
                signs_line4_empty: "(leave blank)",
                img_placeholder_sign: "IMAGE: Completed buy sign",
                signs_img_caption: "The plugin will format the sign with colors automatically.",
                signs_permission: "To create a sign, you need the slotmachine.sign.create permission. Players can use it to open an interactive purchase menu.",
                section_config: "Configuration File (config.yml)",
                config_intro: "The config.yml file allows you to customize every aspect of the plugin. Each section is detailed here:",
                section_commands: "Commands and Permissions",
                commands_intro: "The main command is /slot, with aliases /slots and /tragamonedas. All admin commands require the slotmachine.admin permission.",
                command_create: "Starts the process to create a new machine with the specified name.",
                command_delete: "Permanently deletes an existing slot machine.",
                command_getcoin: "Gives you the specified amount of casino tokens. Defaults to 1.",
                command_reload: "Reloads all plugin configuration files.",
                command_help: "Displays a help message with all available commands.",
                command_ver: "Displays the current version and author of the plugin.",
                permissions_title: "Additional Permissions",
                permission_use: "Allows players to use the slot machines. Granted by default.",
                permission_sign_create: "Allows creating token sale signs. Default for OPs.",
                permission_sign_use: "Allows using signs to buy tokens. Granted by default.",
                permission_discount: "Permissions for discounts defined in config.yml (e.g., slotmachine.discount.vip1).",
                section_messages: "Message Customization",
                messages_intro: "You can translate and customize almost all plugin messages by editing the files in the /lang/ folder. The plugin includes en.yml (English) and es.yml (Spanish) by default.",
                messages_prizes: "To define the winning combinations, you must edit the language file (e.g., en.yml) in the prizes and jackpot section:",
            }
        };

        function setLanguage(lang) {
            document.documentElement.lang = lang;
            document.querySelectorAll('[data-lang]').forEach(el => {
                const key = el.getAttribute('data-lang');
                if (translations[lang] && translations[lang][key]) {
                    el.textContent = translations[lang][key];
                }
            });
        }

        const currentLang = document.documentElement.lang;
        setLanguage(currentLang);

        // --- Lógica para el Modal de Imágenes ---
        const modal = document.getElementById("imageModal");
        const modalImg = document.getElementById("modalImage");
        const closeModal = document.getElementsByClassName("image-modal-close")[0];

        document.querySelectorAll('.clickable-image').forEach(image => {
            image.onclick = function(){
                modal.style.display = "block";
                modalImg.src = this.src;
            }
        });

        closeModal.onclick = function() {
            modal.style.display = "none";
        }

        modal.onclick = function(event) {
            if (event.target == modal) {
                 modal.style.display = "none";
            }
        }
    </script>
</body>
</html>