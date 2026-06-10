<?php
// $contacts, $page, $totalPages, $total are passed from ContactAdminController
?>
<section class="border-b border-[#333] px-6 lg:px-12 py-10">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ CONTACT INBOX ]</p>
            <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">PESAN <span class="text-[#CCFF00]">MASUK</span></h1>
        </div>
        <span class="px-4 py-2 border border-[#333] text-xs font-mono text-[#CCFF00]"><?= $total ?> PESAN</span>
    </div>

    <?php if (empty($contacts)): ?>
        <!-- Empty State -->
        <div class="border border-[#333] p-10 text-center">
            <p class="text-xs font-mono text-[#333] tracking-[.2em] uppercase">[ NO MESSAGES YET ]</p>
            <p class="text-[10px] font-mono text-[#333] mt-3 tracking-[.1em]">Inbox is empty. Contact form submissions will appear here.</p>
        </div>
    <?php else: ?>
        <!-- Table -->
        <div class="border border-[#333] overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="border-b border-[#333]">
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">ID</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">Nama</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em] hidden sm:table-cell">Email</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em] hidden md:table-cell">Subject</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em] hidden lg:table-cell">Tanggal</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $c): ?>
                        <!-- Main Row -->
                        <tr class="border-b border-[#333] hover:bg-[#111]" id="row-<?= (int)$c['id'] ?>">
                            <td class="px-4 py-3 text-[#333]"><?= (int)$c['id'] ?></td>
                            <td class="px-4 py-3 text-white"><?= htmlspecialchars($c['name']) ?></td>
                            <td class="px-4 py-3 text-[#666] hidden sm:table-cell"><?= htmlspecialchars($c['email']) ?></td>
                            <td class="px-4 py-3 text-[#999] hidden md:table-cell max-w-[200px] truncate"><?= htmlspecialchars($c['subject'] ?? '—') ?></td>
                            <td class="px-4 py-3 text-[#333] hidden lg:table-cell"><?= date('Y-m-d', strtotime($c['created_at'])) ?></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <button
                                        onclick="toggleDetail(<?= (int)$c['id'] ?>)"
                                        class="text-[10px] font-mono text-[#666] hover:text-white cursor-pointer bg-transparent border-0 p-0"
                                    >[ VIEW ]</button>
                                    <a
                                        href="/admin/contacts/delete?id=<?= (int)$c['id'] ?>"
                                        class="text-[10px] font-mono text-[#666] hover:text-white no-underline"
                                        onclick="return confirm('Hapus pesan dari <?= htmlspecialchars(addslashes($c['name'])) ?>?')"
                                    >[ DELETE ]</a>
                                </div>
                            </td>
                        </tr>
                        <!-- Detail Row (hidden by default) -->
                        <tr class="border-b border-[#333] bg-[#0d0d0d]" id="detail-<?= (int)$c['id'] ?>" style="display:none;">
                            <td colspan="6" class="px-4 py-5">
                                <div class="max-w-3xl">
                                    <!-- Mobile info (shown only on small screens) -->
                                    <div class="flex flex-wrap gap-x-6 gap-y-1 mb-4 sm:hidden">
                                        <span class="text-[10px] font-mono text-[#666] tracking-[.1em]">EMAIL: <span class="text-[#999]"><?= htmlspecialchars($c['email']) ?></span></span>
                                    </div>
                                    <div class="flex flex-wrap gap-x-6 gap-y-1 mb-4 md:hidden">
                                        <span class="text-[10px] font-mono text-[#666] tracking-[.1em]">SUBJECT: <span class="text-[#CCFF00]"><?= htmlspecialchars($c['subject'] ?? '—') ?></span></span>
                                    </div>
                                    <div class="flex flex-wrap gap-x-6 gap-y-1 mb-4 lg:hidden">
                                        <span class="text-[10px] font-mono text-[#666] tracking-[.1em]">DATE: <span class="text-[#333]"><?= date('Y-m-d H:i', strtotime($c['created_at'])) ?></span></span>
                                    </div>
                                    <!-- Message content -->
                                    <p class="text-[10px] font-mono text-[#CCFF00] tracking-[.2em] uppercase mb-2">[ MESSAGE ]</p>
                                    <div class="border border-[#222] bg-[#111] px-4 py-4 text-sm font-mono text-[#ccc] leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($c['message']) ?></div>
                                    <div class="mt-3 flex items-center gap-6">
                                        <span class="text-[10px] font-mono text-[#333]">RECEIVED: <?= date('D, d M Y H:i:s', strtotime($c['created_at'])) ?></span>
                                        <button
                                            onclick="toggleDetail(<?= (int)$c['id'] ?>)"
                                            class="text-[10px] font-mono text-[#666] hover:text-white cursor-pointer bg-transparent border-0 p-0"
                                        >[ COLLAPSE ]</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <div class="flex items-center justify-center gap-3 mt-8">
                <?php if ($page > 1): ?>
                    <a href="/admin/contacts?page=<?= $page - 1 ?>" class="px-3 py-1.5 text-xs font-mono border border-[#333] text-[#666] hover:text-white no-underline">‹ PREV</a>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="/admin/contacts?page=<?= $i ?>" class="px-3 py-1.5 text-xs font-mono border border-[#333] <?= $i === (int)$page ? 'bg-[#CCFF00] text-[#0a0a0a] border-[#CCFF00]' : 'text-[#666] hover:text-white' ?> no-underline"><?= $i ?></a>
                <?php endfor; ?>
                <?php if ($page < $totalPages): ?>
                    <a href="/admin/contacts?page=<?= $page + 1 ?>" class="px-3 py-1.5 text-xs font-mono border border-[#333] text-[#666] hover:text-white no-underline">NEXT ›</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</section>

<script>
function toggleDetail(id) {
    var row = document.getElementById('detail-' + id);
    if (!row) return;
    row.style.display = (row.style.display === 'none' || row.style.display === '') ? 'table-row' : 'none';
}
</script>
