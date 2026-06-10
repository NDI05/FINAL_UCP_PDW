<section class="border-b border-[#333] px-6 lg:px-12 py-20 lg:py-28">
    <div class="max-w-3xl mx-auto">
        <a href="<?= baseUrl('/articles') ?>" class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline" data-scroll-reveal>[ BACK TO ARTICLES ]</a>
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mt-6" data-scroll-reveal>[ ARTICLE ]</p>
        <h1 class="text-xl sm:text-2xl lg:text-4xl font-bold text-white tracking-tight mt-3" data-scroll-reveal><?= htmlspecialchars($article['title']) ?></h1>
        <div class="flex flex-wrap items-center gap-4 mt-4 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]" data-scroll-reveal>
            <span><?= date('Y.m.d', strtotime($article['created_at'])) ?></span>
            <?php if (!empty($article['author_name'])): ?>
                <span>By <?= htmlspecialchars($article['author_name']) ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (!empty($article['image'])): ?>
    <section class="border-b border-[#333]">
        <div class="h-48 sm:h-64 lg:h-80 bg-[#111] overflow-hidden">
            <img src="<?= baseUrl('/' . htmlspecialchars($article['image'])) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full h-full object-cover grayscale opacity-80" loading="lazy">
        </div>
    </section>
<?php endif; ?>

<section class="border-b border-[#333] px-6 lg:px-12 py-12 lg:py-20">
    <div class="max-w-3xl mx-auto">
        <div class="text-sm sm:text-base font-light text-[#ccc] leading-relaxed whitespace-pre-wrap font-mono" data-scroll-reveal><?= htmlspecialchars($article['content']) ?></div>
    </div>
</section>

<section class="border-b border-[#333] py-12 lg:py-16 text-center px-6">
    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-6" data-scroll-reveal>[ MORE INSIGHTS ]</p>
    <a href="<?= baseUrl('/articles') ?>" class="inline-block px-10 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-sm tracking-[.2em] uppercase font-mono hover:bg-white no-underline" data-scroll-reveal>VIEW ALL ARTICLES</a>
</section>
