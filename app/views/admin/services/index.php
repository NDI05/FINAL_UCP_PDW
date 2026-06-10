<div class="max-w-6xl mx-auto px-6 lg:px-10 py-10">
    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ CMS ]</p>
            <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">SERVICES</h1>
        </div>
        <a href="<?= baseUrl('/admin/services/create') ?>" class="px-5 py-2 bg-[#CCFF00] text-[#0a0a0a] text-[10px] font-mono font-bold tracking-[.2em] uppercase hover:bg-white no-underline">+ CREATE</a>
    </div>

    <div class="border border-[#333] overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-[#333] bg-[#0a0a0a]">
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">#</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">Title</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden sm:table-cell">Order</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($services)): ?>
                    <tr>
                        <td colspan="4" class="px-4 py-12 text-center text-[10px] font-mono text-[#333] uppercase tracking-[.2em]">No services yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($services as $i => $service): ?>
                        <tr class="<?= $i > 0 ? 'border-t border-[#333]' : '' ?> hover:bg-[#111]">
                            <td class="px-4 py-3 text-xs font-mono text-[#666]"><?= (int)$service['id'] ?></td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-display font-semibold text-white">
                                    <?= htmlspecialchars($service['title']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-xs font-mono text-[#666] hidden sm:table-cell"><?= (int)$service['order_num'] ?></td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="<?= baseUrl('/admin/services/edit?id=' . (int)$service['id']) ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline">[ EDIT ]</a>
                                    <a href="<?= baseUrl('/admin/services/delete?id=' . (int)$service['id']) ?>" class="text-[10px] font-mono text-[#666] hover:text-red-400 no-underline" onclick="return confirm('Delete this service?')">[ DELETE ]</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
