<section class="border-b border-[#333] px-6 lg:px-12 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ USERS ]</p>
            <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">MANAGE <span class="text-[#CCFF00]">USERS</span></h1>
        </div>
        <a href="/admin/users/create" class="px-5 py-2.5 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white no-underline">+ NEW USER</a>
    </div>

    <?php if (!empty($_GET['status'])): ?>
        <?php
        $flash = match($_GET['status']) {
            'created' => '[ USER CREATED SUCCESSFULLY ]',
            'updated' => '[ USER UPDATED SUCCESSFULLY ]',
            'deleted' => '[ USER DELETED ]',
            default   => null,
        };
        ?>
        <?php if ($flash): ?>
            <div class="border border-[#CCFF00] px-4 py-3 mb-6">
                <p class="text-xs font-mono text-[#CCFF00] tracking-[.2em]"><?= htmlspecialchars($flash) ?></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (empty($users)): ?>
        <div class="border border-[#333] p-10 text-center">
            <p class="text-xs font-mono text-[#333] tracking-[.2em] uppercase">[ NO USERS FOUND ]</p>
            <a href="/admin/users/create" class="inline-block mt-4 text-xs font-mono text-[#CCFF00] tracking-[.2em] uppercase hover:text-white no-underline">CREATE THE FIRST ONE</a>
        </div>
    <?php else: ?>
        <div class="border border-[#333] overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead>
                    <tr class="border-b border-[#333]">
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">ID</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">Username</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em] hidden sm:table-cell">Email</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">Role</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em] hidden md:table-cell">Created</th>
                        <th class="px-4 py-3 text-[10px] text-[#666] uppercase tracking-[.2em]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $currentUserId = (int)($_SESSION['user_id'] ?? 0);
                    foreach ($users as $u):
                    ?>
                        <tr class="border-b border-[#333] hover:bg-[#111]">
                            <td class="px-4 py-3 text-[#333]"><?= $u['id'] ?></td>
                            <td class="px-4 py-3 text-white"><?= htmlspecialchars($u['username']) ?></td>
                            <td class="px-4 py-3 text-[#666] hidden sm:table-cell"><?= htmlspecialchars($u['email']) ?></td>
                            <td class="px-4 py-3">
                                <span class="<?= $u['role'] === 'admin' ? 'text-[#CCFF00]' : 'text-white' ?>">
                                    <?= htmlspecialchars($u['role']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-[#333] hidden md:table-cell"><?= date('Y-m-d', strtotime($u['created_at'])) ?></td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <a href="/admin/users/edit?id=<?= $u['id'] ?>" class="text-[10px] font-mono text-[#CCFF00] hover:text-white no-underline">[ EDIT ]</a>
                                    <?php if ((int)$u['id'] !== $currentUserId): ?>
                                        <a href="/admin/users/delete?id=<?= $u['id'] ?>"
                                           class="text-[10px] font-mono text-[#666] hover:text-white no-underline"
                                           onclick="return confirm('Delete user <?= htmlspecialchars(addslashes($u['username'])) ?>? This cannot be undone.')">
                                            [ DELETE ]
                                        </a>
                                    <?php else: ?>
                                        <span class="text-[10px] font-mono text-[#333]">[ YOU ]</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
