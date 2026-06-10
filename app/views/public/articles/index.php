<section class="border-b border-[#333] px-6 lg:px-12 py-20 lg:py-28">
    <div class="max-w-6xl mx-auto">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4 text-center" data-scroll-reveal>[ ARTICLES ]</p>
        <h1 class="text-2xl sm:text-3xl lg:text-5xl font-bold text-white text-center tracking-tight" data-scroll-reveal>LATEST <span class="text-[#CCFF00]">INSIGHTS</span></h1>
    </div>
</section>

<section class="border-b border-[#333] px-6 lg:px-12 py-10 lg:py-16">
    <div class="max-w-6xl mx-auto">
        <?php if (empty($articles)): ?>
            <div class="border border-[#333] p-12 text-center">
                <p class="text-xs font-mono text-[#333] tracking-[.2em] uppercase">[ NO ARTICLES YET ]</p>
                <p class="text-[10px] font-mono text-[#333] mt-3">Check back soon for new insights.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 grid-border">
                <?php foreach ($articles as $a): ?>
                    <div>
                        <div data-parallax class="h-40 sm:h-48 lg:h-52 bg-[#111] overflow-hidden">
                            <?php if (!empty($a['image'])): ?>
                                <img src="/<?= htmlspecialchars($a['image']) ?>" alt="<?= htmlspecialchars($a['title']) ?>" class="w-full h-full object-cover grayscale opacity-80" loading="lazy">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center"><span class="text-[10px] font-mono text-[#333]">[ NO IMAGE ]</span></div>
                            <?php endif; ?>
                        </div>
                        <div class="p-4 lg:p-5 border-t border-[#333]">
                            <span class="text-[10px] font-mono text-[#666]"><?= date('Y.m.d', strtotime($a['created_at'])) ?></span>
                            <p class="text-xs font-mono uppercase tracking-[.2em] text-white mt-1.5 leading-relaxed"><?= htmlspecialchars($a['title']) ?></p>
                            <p class="text-[10px] font-mono text-[#666] mt-2 leading-relaxed line-clamp-2"><?= htmlspecialchars(substr(strip_tags($a['content']), 0, 120)) ?>...</p>
                            <a href="/articles/<?= htmlspecialchars($a['slug']) ?>" class="inline-block mt-3 text-[10px] font-mono text-[#CCFF00] tracking-[.2em] uppercase hover:text-white no-underline">[ READ ]</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($totalPages > 1): ?>
                <div class="flex items-center justify-center gap-3 mt-10">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="/articles?page=<?= $i ?>" class="px-3 py-1.5 text-xs font-mono border border-[#333] <?= $i === $page ? 'bg-[#CCFF00] text-[#0a0a0a] border-[#CCFF00]' : 'text-[#666] hover:text-white' ?> no-underline"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
