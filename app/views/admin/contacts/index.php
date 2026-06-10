<div class="max-w-6xl mx-auto px-6 lg:px-10 py-10">
    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ ADMIN ]</p>
            <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">CONTACTS</h1>
        </div>
        <span class="text-[10px] font-mono text-[#333] tracking-[.2em] uppercase"><?= $total ?> total</span>
    </div>

    <div class="border border-[#333] overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-[#333] bg-[#0a0a0a]">
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">#</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">Name</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden sm:table-cell">Email</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden md:table-cell">Subject</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden lg:table-cell">Date</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($contacts)): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-[10px] font-mono text-[#333] uppercase tracking-[.2em]">No contacts yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($contacts as $i => $contact): ?>
                        <tr class="<?= $i > 0 ? 'border-t border-[#333]' : '' ?> hover:bg-[#111]">
                            <td class="px-4 py-3 text-xs font-mono text-[#666]"><?= (int)$contact['id'] ?></td>
                            <td class="px-4 py-3">
                                <a href="/admin/contacts/show?id=<?= (int)$contact['id'] ?>" class="text-xs font-display font-semibold text-white hover:text-[#CCFF00] no-underline">
                                    <?= htmlspecialchars($contact['name']) ?>
                                </a>
                            </td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden sm:table-cell">
                                <?= htmlspecialchars($contact['email']) ?>
                            </td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden md:table-cell">
                                <?= htmlspecialchars(mb_strimwidth($contact['subject'], 0, 40, '…')) ?>
                            </td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden lg:table-cell">
                                <?= date('d/m/y', strtotime($contact['created_at'])) ?>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="/admin/contacts/show?id=<?= (int)$contact['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline">[ VIEW ]</a>
                                    <a href="/admin/contacts/delete?id=<?= (int)$contact['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-red-400 no-underline" onclick="return confirm('Delete this contact?')">[ DELETE ]</a>
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
                <a href="/admin/contacts?page=<?= $page - 1 ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ PREV ]</a>
            <?php endif; ?>
            <span class="text-[10px] font-mono text-[#333]"><?= $page ?> / <?= $totalPages ?></span>
            <?php if ($page < $totalPages): ?>
                <a href="/admin/contacts?page=<?= $page + 1 ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ NEXT ]</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
