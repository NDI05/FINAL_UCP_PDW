<section class="border-b border-[#333] px-6 lg:px-12 py-10">
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ SERVICES CMS ]</p>
            <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">Daftar <span class="text-[#CCFF00]">Layanan</span></h1>
        </div>
        <a href="/admin/services/create" class="px-4 py-2 border border-[#CCFF00] text-xs font-mono text-[#CCFF00] hover:bg-[#CCFF00] hover:text-[#0a0a0a] transition-all no-underline">
            [ + NEW SERVICE ]
        </a>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <div class="border border-[#CCFF00] px-4 py-3 mb-8">
            <p class="text-xs font-mono text-[#CCFF00] tracking-[.2em]">
                [ SERVICE <?= strtoupper(htmlspecialchars($_GET['status'])) ?> SUCCESSFULLY ]
            </p>
        </div>
    <?php endif; ?>

    <?php if (empty($services)): ?>
        <div class="border border-[#333] p-12 text-center">
            <p class="text-xs font-mono text-[#666] tracking-[.2em] uppercase">[ NO SERVICES DEFINED ]</p>
            <a href="/admin/services/create" class="inline-block mt-4 text-xs font-mono text-[#CCFF00] hover:underline">[ ADD FIRST SERVICE ]</a>
        </div>
    <?php else: ?>
        <div class="border border-[#333] overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs font-mono">
                <thead>
                    <tr class="border-b border-[#333] bg-[#0c0c0c] text-[#666] uppercase tracking-[.1em]">
                        <th class="p-4 w-16 text-center">ORDER</th>
                        <th class="p-4 w-24">IMAGE</th>
                        <th class="p-4">TITLE</th>
                        <th class="p-4 w-24 text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($services as $s): 
                        $imgUrl = !empty($s['image']) ? (str_starts_with($s['image'], 'http') ? $s['image'] : '/' . $s['image']) : '';
                    ?>
                        <tr class="border-b border-[#333] hover:bg-[#111]/40 transition-all">
                            <td class="p-4 text-center text-[#CCFF00] font-bold"><?= (int)$s['order_num'] ?></td>
                            <td class="p-4">
                                <?php if ($imgUrl): ?>
                                    <img src="<?= htmlspecialchars($imgUrl) ?>" alt="Service Preview" class="h-10 w-16 object-cover border border-[#333]">
                                <?php else: ?>
                                    <span class="text-[#333]">[ NONE ]</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <p class="text-white font-bold text-sm uppercase"><?= htmlspecialchars($s['title']) ?></p>
                                <p class="text-[#666] text-[10px] mt-1 line-clamp-1 max-w-xl"><?= htmlspecialchars($s['description']) ?></p>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-4">
                                    <a href="/admin/services/edit?id=<?= $s['id'] ?>" class="text-[#CCFF00] hover:text-white transition-all no-underline">[ EDIT ]</a>
                                    <a href="/admin/services/delete?id=<?= $s['id'] ?>" onclick="return confirm('Hapus layanan ini?');" class="text-red-500 hover:text-white transition-all no-underline">[ DELETE ]</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
