<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' fill='%230a0a0a'/%3E%3Ctext x='16' y='22' text-anchor='middle' fill='%23CCFF00' font-family='monospace' font-size='16' font-weight='bold'%3END%3C/text%3E%3C/svg%3E">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter+Tight:ital,wght@0,300;0,400;0,600;0,700;0,800;0,900;1,300;1,400&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ndi: { black: '#0a0a0a', lime: '#CCFF00', gray: '#333333', dim: '#666666', faint: '#999999' }
                    },
                    fontFamily: {
                        display: ['Inter Tight', 'sans-serif'],
                        mono: ['JetBrains Mono', 'Roboto Mono', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-[#0a0a0a] text-white font-display selection:bg-[#CCFF00] selection:text-[#0a0a0a]">

<header data-nav class="fixed top-0 left-0 right-0 z-50" style="background:transparent">
    <nav class="border-b border-[#333] flex items-center justify-between h-14 px-6 lg:px-12 bg-[#0a0a0a]/90 backdrop-blur-sm">
        <a href="/" class="text-[#CCFF00] font-bold tracking-[.15em] text-sm font-mono no-underline">[ NDI ]</a>

        <!-- Desktop Nav (md+) -->
        <ul class="hidden md:flex items-center gap-6 lg:gap-10">
            <li><a href="/" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/') ?> font-mono text-xs tracking-[.2em] uppercase no-underline">[ HOME ]</a></li>
            <li><a href="/about" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/about') ?> font-mono text-xs tracking-[.2em] uppercase no-underline">[ ABOUT ]</a></li>
            <li><a href="/services" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/services') ?> font-mono text-xs tracking-[.2em] uppercase no-underline">[ SERVICES ]</a></li>
            <li><a href="/articles" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/articles') ?> font-mono text-xs tracking-[.2em] uppercase no-underline">[ ARTICLES ]</a></li>
            <li><a href="/contact" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/contact') ?> font-mono text-xs tracking-[.2em] uppercase no-underline">[ CONTACT ]</a></li>
        </ul>

        <!-- Hamburger Button (mobile only, <md) -->
        <button
            id="hamburger-btn"
            class="md:hidden flex flex-col justify-center items-center w-8 h-8 gap-1.5 bg-transparent border-0 cursor-pointer p-0"
            aria-label="Toggle menu"
            onclick="toggleMobileMenu()"
        >
            <span class="block w-5 h-[1px] bg-[#CCFF00] transition-all duration-200" id="ham-line1"></span>
            <span class="block w-5 h-[1px] bg-[#CCFF00] transition-all duration-200" id="ham-line2"></span>
            <span class="block w-5 h-[1px] bg-[#CCFF00] transition-all duration-200" id="ham-line3"></span>
        </button>
    </nav>

    <!-- Mobile Menu Dropdown -->
    <div id="mobile-menu" class="md:hidden bg-[#0a0a0a] border-b border-[#333] overflow-hidden max-h-0 transition-all duration-300">
        <ul class="flex flex-col px-6 py-4 gap-0">
            <li class="border-b border-[#222]"><a href="/" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/') ?> font-mono text-xs tracking-[.2em] uppercase no-underline block py-3">[ HOME ]</a></li>
            <li class="border-b border-[#222]"><a href="/about" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/about') ?> font-mono text-xs tracking-[.2em] uppercase no-underline block py-3">[ ABOUT ]</a></li>
            <li class="border-b border-[#222]"><a href="/services" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/services') ?> font-mono text-xs tracking-[.2em] uppercase no-underline block py-3">[ SERVICES ]</a></li>
            <li class="border-b border-[#222]"><a href="/articles" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/articles') ?> font-mono text-xs tracking-[.2em] uppercase no-underline block py-3">[ ARTICLES ]</a></li>
            <li><a href="/contact" class="<?= currentNavClass($_SERVER['REQUEST_URI'], '/contact') ?> font-mono text-xs tracking-[.2em] uppercase no-underline block py-3">[ CONTACT ]</a></li>
        </ul>
    </div>
</header>

<script>
(function() {
    var isOpen = false;
    window.toggleMobileMenu = function() {
        var menu = document.getElementById('mobile-menu');
        var l1 = document.getElementById('ham-line1');
        var l3 = document.getElementById('ham-line3');
        isOpen = !isOpen;
        if (isOpen) {
            menu.style.maxHeight = menu.scrollHeight + 'px';
            l1.style.transform = 'translateY(5px) rotate(45deg)';
            l3.style.transform = 'translateY(-5px) rotate(-45deg)';
            document.getElementById('ham-line2').style.opacity = '0';
        } else {
            menu.style.maxHeight = '0';
            l1.style.transform = '';
            l3.style.transform = '';
            document.getElementById('ham-line2').style.opacity = '1';
        }
    };
})();
</script>

<main>
