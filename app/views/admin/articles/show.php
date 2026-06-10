<div class="max-w-4xl mx-auto px-6 lg:px-10 py-10">
    <div class="mb-8">
        <a href="/admin/articles" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ &larr; BACK TO ARTICLES ]</a>
    </div>

    <div class="mb-2">
        <?php $status = $article['status']; ?>
        <span class="text-[10px] font-mono <?= $status === 'published' ? 'text-[#CCFF00]' : ($status === 'archived' ? 'text-[#666]' : 'text-white/60') ?> tracking-[.2em]">
            [ <?= strtoupper(htmlspecialchars($status)) ?> ]
        </span>
        <span class="text-[10px] font-mono text-[#333] ml-4">ID: <?= (int)$article['id'] ?></span>
    </div>

    <h1 class="text-3xl lg:text-4xl font-bold text-white tracking-tight mt-2"><?= htmlspecialchars($article['title']) ?></h1>

    <div class="flex items-center gap-4 mt-4 text-[10px] font-mono text-[#666]">
        <span>[ AUTHOR: <?= htmlspecialchars($article['author_name'] ?? '—') ?> ]</span>
        <span>[ CREATED: <?= date('d M Y', strtotime($article['created_at'])) ?> ]</span>
        <?php if ($article['updated_at'] !== $article['created_at']): ?>
            <span>[ UPDATED: <?= date('d M Y', strtotime($article['updated_at'])) ?> ]</span>
        <?php endif; ?>
    </div>

    <?php if (!empty($article['image'])): ?>
        <div class="mt-8 border border-[#333] p-1 inline-block">
            <img src="/<?= htmlspecialchars($article['image']) ?>" alt="<?= htmlspecialchars($article['title']) ?>" class="w-full max-w-xl h-auto max-h-96 object-cover grayscale">
        </div>
    <?php endif; ?>

    <div class="mt-10 border-t border-[#333] pt-8">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4">[ CONTENT ]</p>
        <div class="text-sm font-mono text-[#ccc] leading-relaxed whitespace-pre-wrap">
            <?= htmlspecialchars($article['content']) ?>
        </div>
    </div>

    <div class="flex items-center gap-4 mt-10 pt-8 border-t border-[#333]">
        <a href="/admin/articles/edit?id=<?= (int)$article['id'] ?>" class="px-6 py-2.5 border border-[#333] text-[10px] font-mono text-white hover:border-[#CCFF00] hover:text-[#CCFF00] no-underline tracking-[.2em] uppercase">[ EDIT ]</a>
        <a href="/admin/articles/delete?id=<?= (int)$article['id'] ?>" class="px-6 py-2.5 border border-[#333] text-[10px] font-mono text-[#666] hover:border-red-400 hover:text-red-400 no-underline tracking-[.2em] uppercase" onclick="return confirm('Delete this article?')">[ DELETE ]</a>
    </div>
</div>
