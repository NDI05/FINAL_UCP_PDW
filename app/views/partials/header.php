<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> — NDI</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' fill='%230a0a0a'/%3E%3Ctext x='16' y='22' text-anchor='middle' fill='%23CCFF00' font-family='monospace' font-size='16' font-weight='bold'%3END%3C/text%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,300;0,400;0,600;0,700;0,800;0,900;1,300;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{ndi:{black:'#0a0a0a',lime:'#CCFF00',gray:'#333333',dim:'#666666',faint:'#999999'}},fontFamily:{display:['Inter Tight','sans-serif'],mono:['JetBrains Mono','Roboto Mono','monospace']}}}}</script>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-[#0a0a0a] text-white font-display selection:bg-[#CCFF00] selection:text-[#0a0a0a]">
<header data-nav class="fixed top-0 left-0 right-0 z-50" style="background:transparent">
    <nav class="border-b border-[#333] flex items-center justify-between h-14 px-6 lg:px-12">
        <a href="/" class="text-[#CCFF00] font-bold tracking-[.15em] text-sm font-mono no-underline">[ NDI ]</a>
        <ul class="flex items-center gap-6 lg:gap-10">
            <li><a href="/" class="text-[#666] hover:text-white font-mono text-xs tracking-[.2em] uppercase no-underline">[ HOME ]</a></li>
            <li><a href="/articles" class="text-[#CCFF00] font-mono text-xs tracking-[.2em] uppercase no-underline">[ ARTICLES ]</a></li>
            <li><a href="/contact" class="text-[#666] hover:text-white font-mono text-xs tracking-[.2em] uppercase no-underline">[ CONTACT ]</a></li>
        </ul>
    </nav>
</header>
<main>
