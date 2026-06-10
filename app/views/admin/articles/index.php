<section class="border-b border-[#333] px-6 lg:px-12 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ ARTICLES ]</p>
            <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">MANAGE <span class="text-[#CCFF00]">ARTICLES</span></h1>
        </div>
        <a href="/admin/articles/create" class="px-5 py-2.5 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white no-underline">+ NEW</a>
    </div>

    <?php if (empty($articles)): ?>
        <div class="border border-[#333] p-10 text-center">
            <p class="text-xs font-mono text-[#333] tracking-[.2em] uppercase">[ NO ARTICLES YET ]</p>
            <a href="/admin/articles/create" class="inline-block mt-4 text-xs font-mono text-[#CCFF00] tracking-[.2em] uppercase hover:text-white no-underline">CREATE THE FIRST ONE</a>
        </div>
    <?php else: ?>
        <div class="border border-[#333] overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="border-b border-[#333]">
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">ID</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">Title</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em] hidden sm:table-cell">Status</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em] hidden lg:table-cell">Author</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em] hidden md:table-cell">Date</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $a): ?>
                        <tr class="border-b border-[#333] hover:bg-[#111]">
                            <td class="px-4 py-3 text-[#333]"><?= $a['id'] ?></td>
                            <td class="px-4 py-3 text-white"><?= htmlspecialchars($a['title']) ?></td>
                            <td class="px-4 py-3 hidden sm:table-cell"><span class="<?= $a['status'] === 'published' ? 'text-[#CCFF00]' : ($a['status'] === 'draft' ? 'text-[#666]' : 'text-[#333]') ?>"><?= $a['status'] ?></span></td>
                            <td class="px-4 py-3 text-[#666] hidden lg:table-cell"><?= htmlspecialchars($a['author_name'] ?? '—') ?></td>
                            <td class="px-4 py-3 text-[#333] hidden md:table-cell"><?= date('Y-m-d', strtotime($a['created_at'])) ?></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <a href="/admin/articles/show?id=<?= $a['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline">[ VIEW ]</a>
                                    <a href="/admin/articles/edit?id=<?= $a['id'] ?>" class="text-[10px] font-mono text-[#CCFF00] hover:text-white no-underline">[ EDIT ]</a>
                                    <a href="/admin/articles/delete?id=<?= $a['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline" onclick="return confirm('Delete this article?')">[ DELETE ]</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="flex items-center justify-center gap-3 mt-8">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="/admin/articles?page=<?= $i ?>" class="px-3 py-1.5 text-xs font-mono border border-[#333] <?= $i === (int)($page) ? 'bg-[#CCFF00] text-[#0a0a0a] border-[#CCFF00]' : 'text-[#666] hover:text-white' ?> no-underline"><?= $i ?></a>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</section>
