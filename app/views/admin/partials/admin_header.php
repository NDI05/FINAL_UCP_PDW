<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — NDI CMS</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' fill='%230a0a0a'/%3E%3Ctext x='16' y='22' text-anchor='middle' fill='%23CCFF00' font-family='monospace' font-size='16' font-weight='bold'%3END%3C/text%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{ndi:{black:'#0a0a0a',lime:'#CCFF00',gray:'#333333',dim:'#666666',faint:'#999999'}},fontFamily:{display:['Inter Tight','sans-serif'],mono:['JetBrains Mono','Roboto Mono','monospace']}}}}</script>
    <link rel="stylesheet" href="<?= baseUrl('/css/style.css') ?>">
</head>
<body class="bg-[#0a0a0a] text-white font-display">
<header class="border-b border-[#333]">
    <nav class="flex items-center justify-between h-14 px-6 lg:px-12">
        <div class="flex items-center gap-6 flex-wrap">
            <a href="<?= baseUrl('/admin') ?>" class="text-[#CCFF00] font-bold tracking-[.15em] text-sm font-mono no-underline">[ NDI CMS ]</a>
            <a href="<?= baseUrl('/admin/articles') ?>" class="text-xs font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline">[ ARTICLES ]</a>
            <a href="<?= baseUrl('/admin/contacts') ?>" class="text-xs font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline">[ CONTACTS ]</a>
            <a href="<?= baseUrl('/admin/users') ?>" class="text-xs font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline">[ USERS ]</a>
            <a href="<?= baseUrl('/admin/services') ?>" class="text-xs font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline">[ SERVICES ]</a>
            <a href="<?= baseUrl('/admin/team') ?>" class="text-xs font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline">[ TEAM ]</a>
            <a href="<?= baseUrl('/admin/settings') ?>" class="text-xs font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline">[ SETTINGS ]</a>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-[10px] font-mono text-[#666]"><?= htmlspecialchars($_SESSION['username'] ?? '') ?></span>
            <a href="<?= baseUrl('/admin/logout') ?>" class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline">[ LOGOUT ]</a>
        </div>
    </nav>
</header>
<main>
