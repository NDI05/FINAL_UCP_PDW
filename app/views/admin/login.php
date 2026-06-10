<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>[ LOGIN ] — NDI CMS</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' fill='%230a0a0a'/%3E%3Ctext x='16' y='22' text-anchor='middle' fill='%23CCFF00' font-family='monospace' font-size='16' font-weight='bold'%3END%3C/text%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:wght@300;400;600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={theme:{extend:{colors:{ndi:{black:'#0a0a0a',lime:'#CCFF00',gray:'#333333',dim:'#666666',faint:'#999999'}},fontFamily:{display:['Inter Tight','sans-serif'],mono:['JetBrains Mono','Roboto Mono','monospace']}}}}</script>
    <style>*{border-radius:0!important}::selection{background:#CCFF00;color:#0a0a0a}</style>
</head>
<body class="bg-[#0a0a0a] text-white font-display min-h-screen flex items-center justify-center px-6">
    <div class="w-full max-w-sm border border-[#333] p-8">
        <p class="text-center text-[#CCFF00] font-bold tracking-[.15em] text-sm font-mono mb-8">[ NDI CMS ]</p>
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-6 text-center">[ ADMIN LOGIN ]</p>

        <?php if (!empty($error)): ?>
            <div class="border border-[#333] px-4 py-3 mb-6"><p class="text-xs font-mono text-[#666] text-center"><?= htmlspecialchars($error) ?></p></div>
        <?php endif; ?>

        <form method="POST" action="/admin/login" class="space-y-5">
            <div>
                <label for="username" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ USERNAME / EMAIL ]</label>
                <input type="text" id="username" name="username" required class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline">
            </div>
            <div>
                <label for="password" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ PASSWORD ]</label>
                <input type="password" id="password" name="password" required class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline">
            </div>
            <button type="submit" class="w-full py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white no-underline">LOGIN</button>
        </form>

        <a href="/" class="block text-center mt-6 text-[10px] font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline">[ BACK TO SITE ]</a>
    </div>
</body>
</html>
