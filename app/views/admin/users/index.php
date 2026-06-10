<div class="max-w-6xl mx-auto px-6 lg:px-10 py-10">
    <div class="flex items-center justify-between mb-10">
        <div>
            <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ ADMIN ]</p>
            <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">USERS</h1>
        </div>
        <a href="/admin/users/create" class="px-5 py-2 bg-[#CCFF00] text-[#0a0a0a] text-[10px] font-mono font-bold tracking-[.2em] uppercase hover:bg-white no-underline">+ CREATE</a>
    </div>

    <div class="border border-[#333] overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b border-[#333] bg-[#0a0a0a]">
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">#</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em]">Username</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden sm:table-cell">Email</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden md:table-cell">Role</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] hidden lg:table-cell">Created</th>
                    <th class="px-4 py-3 text-[10px] font-mono text-[#666] uppercase tracking-[.2em] text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-[10px] font-mono text-[#333] uppercase tracking-[.2em]">No users found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $i => $u): ?>
                        <tr class="<?= $i > 0 ? 'border-t border-[#333]' : '' ?> hover:bg-[#111]">
                            <td class="px-4 py-3 text-xs font-mono text-[#666]"><?= (int)$u['id'] ?></td>
                            <td class="px-4 py-3">
                                <span class="text-xs font-display font-semibold text-white"><?= htmlspecialchars($u['username']) ?></span>
                            </td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden sm:table-cell">
                                <?= htmlspecialchars($u['email']) ?>
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell">
                                <span class="text-[10px] font-mono <?= $u['role'] === 'admin' ? 'text-[#CCFF00]' : 'text-white/60' ?>">
                                    [ <?= strtoupper(htmlspecialchars($u['role'])) ?> ]
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[10px] font-mono text-[#666] hidden lg:table-cell">
                                <?= date('d/m/y', strtotime($u['created_at'])) ?>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="/admin/users/edit?id=<?= (int)$u['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-white no-underline">[ EDIT ]</a>
                                    <?php if ((int)$u['id'] !== (int)($_SESSION['user_id'] ?? 0)): ?>
                                        <a href="/admin/users/delete?id=<?= (int)$u['id'] ?>" class="text-[10px] font-mono text-[#666] hover:text-red-400 no-underline" onclick="return confirm('Delete this user?')">[ DELETE ]</a>
                                    <?php else: ?>
                                        <span class="text-[10px] font-mono text-[#333] tracking-[.2em]">[ YOU ]</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
