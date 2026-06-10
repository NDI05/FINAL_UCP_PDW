<section class="border-b border-[#333] px-6 lg:px-12 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ TEAM CMS ]</p>
            <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">Anggota <span class="text-[#CCFF00]">Tim</span></h1>
        </div>
        <a href="/admin/team/create" class="px-4 py-2 border border-[#CCFF00] text-xs font-mono text-[#CCFF00] hover:bg-[#CCFF00] hover:text-[#0a0a0a] transition-all no-underline">
            [ + NEW MEMBER ]
        </a>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <div class="border border-[#CCFF00] px-4 py-3 mb-8">
            <p class="text-xs font-mono text-[#CCFF00] tracking-[.2em]">
                [ TEAM MEMBER <?= strtoupper(htmlspecialchars($_GET['status'])) ?> SUCCESSFULLY ]
            </p>
        </div>
    <?php endif; ?>

    <?php if (empty($members)): ?>
        <div class="border border-[#333] p-12 text-center">
            <p class="text-xs font-mono text-[#666] tracking-[.2em] uppercase">[ NO TEAM MEMBERS DEFINED ]</p>
            <a href="/admin/team/create" class="inline-block mt-4 text-xs font-mono text-[#CCFF00] hover:underline">[ ADD FIRST MEMBER ]</a>
        </div>
    <?php else: ?>
        <div class="border border-[#333] overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs font-mono">
                <thead>
                    <tr class="border-b border-[#333] bg-[#0c0c0c] text-[#666] uppercase tracking-[.1em]">
                        <th class="p-4 w-16 text-center">ORDER</th>
                        <th class="p-4 w-20">AVATAR</th>
                        <th class="p-4">NAME</th>
                        <th class="p-4">ROLE</th>
                        <th class="p-4 w-24 text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($members as $m): 
                        $imgUrl = !empty($m['image']) ? (str_starts_with($m['image'], 'http') ? $m['image'] : '/' . $m['image']) : '';
                    ?>
                        <tr class="border-b border-[#333] hover:bg-[#111]/40 transition-all">
                            <td class="p-4 text-center text-[#CCFF00] font-bold"><?= (int)$m['order_num'] ?></td>
                            <td class="p-4">
                                <?php if ($imgUrl): ?>
                                    <img src="<?= htmlspecialchars($imgUrl) ?>" alt="Member Photo" class="h-10 w-10 rounded-full object-cover border border-[#333]">
                                <?php else: ?>
                                    <div class="h-10 w-10 rounded-full bg-[#333] flex items-center justify-center text-[10px] text-white">?</div>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 font-bold text-white uppercase text-sm"><?= htmlspecialchars($m['name']) ?></td>
                            <td class="p-4 text-[#999] uppercase"><?= htmlspecialchars($m['role']) ?></td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="/admin/team/edit?id=<?= $m['id'] ?>" class="text-[#CCFF00] hover:text-white transition-all no-underline">[ EDIT ]</a>
                                    <a href="/admin/team/delete?id=<?= $m['id'] ?>" onclick="return confirm('Hapus anggota tim ini?');" class="text-red-500 hover:text-white transition-all no-underline">[ DELETE ]</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
