<div class="max-w-6xl mx-auto px-6 lg:px-10 py-10">
    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ CMS ]</p>
            <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">TEAM</h1>
        </div>
        <a href="/admin/team/create" class="px-5 py-2 bg-[#CCFF00] text-[#0a0a0a] text-[10px] font-mono font-bold tracking-[.2em] uppercase hover:bg-white no-underline">+ ADD MEMBER</a>
    </div>

    <div class="border border-[#333] overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-[#333] bg-[#0a0a0a]">
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">#</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">Name</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden sm:table-cell">Role</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden md:table-cell">Order</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($members)): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-12 text-center text-[10px] font-mono text-[#333] uppercase tracking-[.2em]">No team members yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($members as $i => $member): ?>
                        <tr class="<?= $i > 0 ? 'border-t border-[#333]' : '' ?> hover:bg-[#111]">
                            <td class="px-4 py-3 text-xs font-mono text-[#666]"><?= (int)$member['id'] ?></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <?php if (!empty($member['image'])): ?>
                                        <img src="/<?= htmlspecialchars($member['image']) ?>" alt="" class="w-8 h-8 object-cover grayscale border border-[#333]">
                                    <?php else: ?>
                                        <div class="w-8 h-8 bg-[#111] border border-[#333] flex items-center justify-center text-[10px] font-mono text-[#333]">—</div>
                                    <?php endif; ?>
                                    <span class="text-xs font-display font-semibold text-white"><?= htmlspecialchars($member['name']) ?></span>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden sm:table-cell"><?= htmlspecialchars($member['role']) ?></td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden md:table-cell"><?= (int)$member['order_num'] ?></td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="/admin/team/edit?id=<?= (int)$member['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline">[ EDIT ]</a>
                                    <a href="/admin/team/delete?id=<?= (int)$member['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-red-400 no-underline" onclick="return confirm('Delete this team member?')">[ DELETE ]</a>
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
                <a href="/admin/team?page=<?= $page - 1 ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ PREV ]</a>
            <?php endif; ?>
            <span class="text-[10px] font-mono text-[#333]"><?= $page ?> / <?= $totalPages ?></span>
            <?php if ($page < $totalPages): ?>
                <a href="/admin/team?page=<?= $page + 1 ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ NEXT ]</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
