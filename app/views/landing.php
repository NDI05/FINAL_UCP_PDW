<!-- SECTION A: HERO -->
<section class="relative h-screen border-b border-[#333] overflow-hidden bg-[#0a0a0a] flex items-center">
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1600&h=900&fit=crop&q=80" alt="Data center" class="w-full h-full object-cover grayscale opacity-30" loading="eager">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0a0a0a] via-transparent to-[#0a0a0a]"></div>
    </div>
    <span class="absolute top-6 left-6 lg:top-10 lg:left-12 text-[10px] sm:text-xs font-mono text-[#666] tracking-[.15em] z-10 animate-pulse-dot">[ <?= strtoupper(htmlspecialchars(SiteSetting::get('landing_hero_eyebrow', 'DIGITAL INFRASTRUCTURE'))) ?> ]</span>
    <span class="absolute top-6 right-6 lg:top-10 lg:right-12 text-[10px] sm:text-xs font-mono text-[#666] tracking-[.15em] z-10">[ EST. 2026 ]</span>
    <div class="relative z-10 pl-4 sm:pl-8 lg:pl-12 max-w-4xl">
        <h1 class="text-[8vw] sm:text-[10vw] lg:text-[12vw] font-black text-white leading-none tracking-tighter mix-blend-difference select-none uppercase">
            <?= str_replace(' ', '<br>', htmlspecialchars(SiteSetting::get('landing_hero_title', 'NUSA DATA'))) ?>
        </h1>
        <?php if ($subtitle = SiteSetting::get('landing_hero_subtitle')): ?>
            <p class="text-[10px] sm:text-xs font-mono text-[#999] tracking-wider uppercase mt-4 max-w-md mix-blend-difference">
                <?= htmlspecialchars($subtitle) ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="absolute bottom-6 right-6 lg:bottom-12 lg:right-12 w-28 h-36 sm:w-36 sm:h-48 lg:w-44 lg:h-56 overflow-hidden border border-[#333]">
        <img src="https://images.unsplash.com/photo-1560264280-88b68371db39?w=400&h=500&fit=crop&q=80" alt="Server detail" class="w-full h-full object-cover grayscale" loading="lazy">
    </div>
    <span class="absolute bottom-6 left-6 lg:bottom-10 lg:left-12 text-[10px] sm:text-xs font-mono text-[#666] z-10">LAT: -7.797, LONG: 110.370</span>
</section>

<!-- SECTION B: THE STATEMENT -->
<section class="relative border-b border-[#333] py-20 md:py-24 lg:py-32 overflow-hidden">
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none overflow-hidden">
        <span class="text-[12rem] sm:text-[18rem] md:text-[20rem] lg:text-[24rem] font-black text-white/5 leading-none">ABOUT</span>
    </div>
    <div class="relative z-10 max-w-5xl mx-auto px-6 lg:px-12">
        <p class="text-xs sm:text-sm font-mono text-[#666] tracking-[.3em] uppercase mb-8 text-center" data-scroll-reveal>[ STATEMENT ]</p>
        <p class="text-base sm:text-lg md:text-lg lg:text-xl font-light uppercase tracking-[.15em] leading-relaxed text-center max-w-4xl mx-auto" data-scroll-reveal>
            <?= strtoupper(htmlspecialchars(SiteSetting::get('landing_statement', 'FOUNDED IN YOGYAKARTA IN 2026, NUSA DATA INDONESIA IS BUILT ON AN UNWAVERING COMMITMENT TO DIGITAL CRAFTSMANSHIP.'))) ?>
        </p>
    </div>
    <span class="absolute left-6 lg:left-12 top-1/4 text-5xl lg:text-7xl text-[#333] font-mono select-none">*</span>
    <span class="absolute right-6 lg:right-12 bottom-1/4 text-4xl lg:text-6xl text-[#333] font-mono select-none">*</span>
    <span class="absolute left-1/3 bottom-8 text-3xl text-[#333] font-mono select-none">*</span>
</section>

<!-- SECTION C: SERVICES GRID -->
<section class="border-b border-[#333]" id="services-grid">
    <div class="px-6 lg:px-12 py-5 border-b border-[#333] flex items-center justify-between">
        <h2 class="text-xs font-mono tracking-[.3em] uppercase text-[#666]">AVAILABLE <span class="text-[#CCFF00]">SERVICES</span></h2>
        <span class="text-[10px] font-mono text-[#333]">[ 04 ]</span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 grid-border">
        <?php 
        $allServices = Service::getAll();
        $i = 1;
        foreach ($allServices as $s): 
            $title = $s['title'];
            $desc = $s['description'];
            $img = $s['image'];
            $imgUrl = !empty($img) ? (str_starts_with($img, 'http') ? $img : baseUrl('/' . ltrim($img, '/'))) : '';
        ?>
            <div>
                <div data-parallax class="h-40 sm:h-48 lg:h-56 bg-[#111] overflow-hidden">
                    <?php if ($imgUrl): ?>
                        <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($title) ?>" class="w-full h-full object-cover grayscale opacity-80" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center"><span class="text-[10px] font-mono text-[#333]">[ NO IMAGE ]</span></div>
                    <?php endif; ?>
                </div>
                <div class="p-4 lg:p-5 border-t border-[#333]">
                    <span class="text-[10px] font-mono text-[#666]">SVC-<?= str_pad($i, 3, '0', STR_PAD_LEFT) ?></span>
                    <p class="text-xs font-mono uppercase tracking-[.2em] text-white mt-1.5"><?= htmlspecialchars($title) ?></p>
                    <p class="text-[10px] font-mono text-[#666] mt-2 leading-relaxed line-clamp-3"><?= htmlspecialchars($desc) ?></p>
                </div>
            </div>
        <?php $i++; endforeach; ?>
    </div>
</section>

<!-- SECTION: LATEST ARTICLES -->
<?php
$latestArticles = Article::getAllPublished(1, 3);
if (!empty($latestArticles)):
?>
<section class="border-b border-[#333]" id="latest-articles">
    <div class="px-6 lg:px-12 py-5 border-b border-[#333] flex items-center justify-between">
        <h2 class="text-xs font-mono tracking-[.3em] uppercase text-[#666]">LATEST <span class="text-[#CCFF00]">INSIGHTS</span></h2>
        <a href="<?= baseUrl('/articles') ?>" class="text-[10px] font-mono text-[#CCFF00] tracking-[.2em] uppercase hover:text-white no-underline">[ ALL ARTICLES ]</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 grid-border">
        <?php foreach ($latestArticles as $a): ?>
            <div>
                <div data-parallax class="h-40 sm:h-48 lg:h-56 bg-[#111] overflow-hidden">
                    <?php if (!empty($a['image'])): ?>
                        <img src="<?= baseUrl('/' . htmlspecialchars($a['image'])) ?>" alt="<?= htmlspecialchars($a['title']) ?>" class="w-full h-full object-cover grayscale opacity-80" loading="lazy">
                    <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center"><span class="text-[10px] font-mono text-[#333]">[ NO IMAGE ]</span></div>
                    <?php endif; ?>
                </div>
                <div class="p-4 lg:p-5 border-t border-[#333]">
                    <span class="text-[10px] font-mono text-[#666]"><?= date('Y.m.d', strtotime($a['created_at'])) ?></span>
                    <p class="text-xs font-mono uppercase tracking-[.2em] text-white mt-1.5 leading-relaxed"><?= htmlspecialchars($a['title']) ?></p>
                    <p class="text-[10px] font-mono text-[#666] mt-2 leading-relaxed line-clamp-2"><?= htmlspecialchars(substr(strip_tags($a['content']), 0, 120)) ?>...</p>
                    <a href="<?= baseUrl('/articles/' . htmlspecialchars($a['slug'])) ?>" class="inline-block mt-3 text-[10px] font-mono text-[#CCFF00] tracking-[.2em] uppercase hover:text-white no-underline">[ READ ]</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- SECTION D: THE MANIFESTO -->
<section class="border-b border-[#333] py-20 md:py-24 lg:py-28 px-6 md:px-10 lg:px-12">
    <div class="max-w-6xl mx-auto">
        <p class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-light text-white leading-tight" data-scroll-reveal>FOUNDED TO <span class="text-[#CCFF00] font-semibold">REDEFINE</span></p>
        <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-light text-white mt-8 sm:mt-12 text-right" data-scroll-reveal><span class="text-[#CCFF00] font-bold">CREATED</span> WITH RIGOR</p>
        <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-light text-white mt-8 sm:mt-12 text-center lg:text-right" data-scroll-reveal>FORM, FUNCTION, AND <span class="text-[#CCFF00] font-semibold">FEEL</span></p>
        <div class="mt-16 lg:mt-20 flex justify-center" data-scroll-reveal><div class="w-12 h-[1px] bg-[#CCFF00]"></div></div>
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase text-center mt-6" data-scroll-reveal>[ ENGINEERED IN YOGYAKARTA ]</p>
    </div>
</section>

<!-- CTA -->
<section class="border-b border-[#333] py-16 md:py-20 lg:py-24 text-center px-6">
    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-6" data-scroll-reveal>[ LET'S WORK TOGETHER ]</p>
    <a href="<?= baseUrl('/contact') ?>" class="inline-block px-10 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-sm tracking-[.2em] uppercase font-mono hover:bg-white no-underline" data-scroll-reveal>INITIATE PROJECT</a>
</section>
