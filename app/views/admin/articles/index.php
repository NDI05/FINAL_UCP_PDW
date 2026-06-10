<div class="max-w-6xl mx-auto px-6 lg:px-10 py-10">
    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ CMS ]</p>
            <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">ARTICLES</h1>
        </div>
        <a href="/admin/articles/create" class="px-5 py-2 bg-[#CCFF00] text-[#0a0a0a] text-[10px] font-mono font-bold tracking-[.2em] uppercase hover:bg-white no-underline">+ CREATE</a>
    </div>

    <div class="border border-[#333] overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-[#333] bg-[#0a0a0a]">
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">ID</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">Title</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden sm:table-cell">Status</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden md:table-cell">Author</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden lg:table-cell">Date</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($articles)): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-[10px] font-mono text-[#333] uppercase tracking-[.2em]">No articles yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($articles as $i => $article): ?>
                        <tr class="<?= $i > 0 ? 'border-t border-[#333]' : '' ?> hover:bg-[#111]">
                            <td class="px-4 py-3 text-xs font-mono text-[#666]"><?= (int)$article['id'] ?></td>
                            <td class="px-4 py-3">
                                <a href="/admin/articles/show?id=<?= (int)$article['id'] ?>" class="text-xs font-display font-semibold text-white hover:text-[#CCFF00] no-underline">
                                    <?= htmlspecialchars($article['title']) ?>
                                </a>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <?php $status = $article['status']; ?>
                                <span class="text-[10px] font-mono <?= $status === 'published' ? 'text-[#CCFF00]' : ($status === 'archived' ? 'text-[#666]' : 'text-white/60') ?>">
                                    [ <?= strtoupper(htmlspecialchars($status)) ?> ]
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden md:table-cell">
                                <?= htmlspecialchars($article['author_name'] ?? '—') ?>
                            </td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden lg:table-cell">
                                <?= date('d/m/y', strtotime($article['created_at'])) ?>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="/admin/articles/edit?id=<?= (int)$article['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline">[ EDIT ]</a>
                                    <a href="/admin/articles/delete?id=<?= (int)$article['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-red-400 no-underline" onclick="return confirm('Delete this article?')">[ DELETE ]</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="flex items-center justify-center gap-4 mt-8">
            <?php if ($page > 1): ?>
                <a href="/admin/articles?page=<?= $page - 1 ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ PREV ]</a>
            <?php endif; ?>
            <span class="text-[10px] font-mono text-[#333]"><?= $page ?> / <?= $totalPages ?></span>
            <?php if ($page < $totalPages): ?>
                <a href="/admin/articles?page=<?= $page + 1 ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ NEXT ]</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
