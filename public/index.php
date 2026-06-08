<?php
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/helpers/Visitor.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';

if ($uri === '/admin/logout') {
    require_once __DIR__ . '/../app/controllers/AuthController.php';
    (new AuthController())->logout();
    exit;
}

if ($uri === '/admin/login') {
    require_once __DIR__ . '/../app/controllers/AuthController.php';
    (new AuthController())->login();
    exit;
}

if (str_starts_with($uri, '/admin')) {
    require_once __DIR__ . '/../app/controllers/AuthController.php';
    (new AuthController())->requireAuth();

    trackVisitor();

    require_once __DIR__ . '/../app/models/Visitor.php';
    $todayVisitors = Visitor::getTodayCount();
    $totalVisitors = Visitor::getTotalCount();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title>Ridha Core — NDI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@400;600;700;900&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{ndi:{black:'#0a0a0a',lime:'#CCFF00',gray:'#333333',dim:'#666666'}},fontFamily:{display:['Inter Tight','sans-serif'],mono:['JetBrains Mono','monospace']}}}}</script>
    <style>*{border-radius:0!important}::selection{background:#CCFF00;color:#0a0a0a}</style>
    </head>
    <body class="bg-[#0a0a0a] text-white font-display">
    <header class="border-b border-[#333]"><nav class="flex items-center justify-between h-12 px-6 lg:px-10">
        <span class="text-[#CCFF00] font-bold tracking-[.15em] text-sm font-mono">[ NDI CORE ]</span>
        <div class="flex items-center gap-4">
            <span class="text-[10px] font-mono text-[#666]">[ <?= htmlspecialchars($_SESSION['username'] ?? '') ?> ]</span>
            <a href="/admin/logout" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ LOGOUT ]</a>
        </div>
    </nav></header>
    <div class="max-w-4xl mx-auto px-6 py-10">
        <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ RIDHA CORE ]</p>
        <h1 class="text-2xl font-bold text-white tracking-tight mt-2">SYSTEM <span class="text-[#CCFF00]">DASHBOARD</span></h1>
        <div class="grid grid-cols-2 gap-6 mt-8">
            <div class="border border-[#333] p-6"><p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase">[ TODAY ]</p><p class="text-3xl font-bold text-[#CCFF00] mt-2"><?= $todayVisitors ?></p><p class="text-[10px] font-mono text-[#666] mt-1">visitors</p></div>
            <div class="border border-[#333] p-6"><p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase">[ TOTAL ]</p><p class="text-3xl font-bold text-white mt-2"><?= $totalVisitors ?></p><p class="text-[10px] font-mono text-[#666] mt-1">all time</p></div>
        </div>
        <p class="text-[10px] font-mono text-[#333] mt-10 text-center tracking-[.2em] uppercase">Database: <?= DB_NAME ?> &middot; Ridha Core v1.0</p>
    </div>
    </body></html>
    <?php
    exit;
}

http_response_code(404);
echo '<div class="min-h-screen flex items-center justify-center bg-[#0a0a0a]"><p class="text-[#666] font-mono text-sm">[ 404 ] This server only handles /admin/* routes.</p></div>';
