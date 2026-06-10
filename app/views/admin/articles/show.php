<section class="border-b border-[#333] px-6 lg:px-12 py-10 max-w-3xl">
    <a href="/admin/articles" class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline mb-6 inline-block">[ BACK TO ARTICLES ]</a>

    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mt-4">[ ARTICLE ] <span class="text-[#333]">#<?= $article['id'] ?></span></p>
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white tracking-tight mt-2"><?= htmlspecialchars($article['title']) ?></h1>

    <div class="flex flex-wrap items-center gap-4 mt-4 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">
        <span>Status: <span class="<?= $article['status'] === 'published' ? 'text-[#CCFF00]' : ($article['status'] === 'draft' ? 'text-[#666]' : 'text-[#333]') ?>"><?= $article['status'] ?></span></span>
        <span>Author: <?= htmlspecialchars($article['author_name'] ?? '—') ?></span>
        <span>Created: <?= date('Y-m-d H:i', strtotime($article['created_at'])) ?></span>
        <?php if ($article['updated_at'] !== $article['created_at']): ?>
            <span>Updated: <?= date('Y-m-d H:i', strtotime($article['updated_at'])) ?></span>
        <?php endif; ?>
    </div>

    <?php if (!empty($article['image'])): ?>
        <div class="mt-6 border border-[#333] p-2 inline-block">
            <img src="/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="h-48 sm:h-64 object-contain grayscale">
        </div>
    <?php endif; ?>

    <div class="mt-8 text-sm font-light text-[#ccc] leading-relaxed whitespace-pre-wrap font-mono"><?= htmlspecialchars($article['content']) ?></div>

    <div class="flex items-center gap-4 mt-10 pt-6 border-t border-[#333]">
        <a href="/admin/articles/edit?id=<?= $article['id'] ?>" class="px-6 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white no-underline">EDIT</a>
        <a href="/admin/articles/delete?id=<?= $article['id'] ?>" class="px-6 py-3 border border-[#333] text-[#666] text-xs tracking-[.2em] uppercase font-mono hover:border-white hover:text-white no-underline" onclick="return confirm('Delete this article?')">DELETE</a>
    </div>
</section>
