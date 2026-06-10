<section class="border-b border-[#333] px-6 lg:px-12 py-10">
    <div class="mb-8">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ SETTINGS ]</p>
        <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">SITE <span class="text-[#CCFF00]">SETTINGS</span></h1>
    </div>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'saved'): ?>
        <div class="border border-[#CCFF00] px-4 py-3 mb-8">
            <p class="text-xs font-mono text-[#CCFF00] tracking-[.2em]">[ SETTINGS SAVED SUCCESSFULLY ]</p>
        </div>
    <?php endif; ?>

    <?php if (empty($grouped)): ?>
        <div class="border border-[#333] p-10 text-center">
            <p class="text-xs font-mono text-[#333] tracking-[.2em] uppercase">[ NO SETTINGS FOUND — RUN SEED SQL ]</p>
        </div>
    <?php else: ?>
        <form method="POST" action="/admin/settings" enctype="multipart/form-data" class="space-y-12 max-w-3xl">
            <?php foreach ($grouped as $group => $items): ?>
                <div>
                    <div class="flex items-center gap-4 mb-6">
                        <p class="text-[10px] font-mono text-[#CCFF00] tracking-[.3em] uppercase">
                            [ <?= htmlspecialchars(strtoupper($group)) ?> ]
                        </p>
                        <div class="flex-1 border-t border-[#222]"></div>
                    </div>
                    <div class="space-y-5">
                        <?php foreach ($items as $s): ?>
                            <div>
                                <label class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">
                                    [ <?= htmlspecialchars(strtoupper($s['label'] ?: $s['key'])) ?> ]
                                </label>
                                <?php if (str_ends_with($s['key'], '_image')): ?>
                                    <?php if (!empty($s['value'])): ?>
                                        <div class="mb-2">
                                            <img src="<?= str_starts_with($s['value'], 'http') ? htmlspecialchars($s['value']) : '/' . htmlspecialchars($s['value']) ?>" alt="Preview" class="h-24 object-contain border border-[#333] p-1 bg-[#111]">
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex flex-col gap-2">
                                        <input type="text"
                                               name="settings[<?= htmlspecialchars($s['key']) ?>]"
                                               value="<?= htmlspecialchars($s['value']) ?>"
                                               placeholder="Or paste an image URL..."
                                               class="w-full bg-transparent border border-[#333] px-4 py-2.5 text-white text-xs font-mono outline-none focus:border-[#CCFF00]">
                                        <input type="file"
                                               name="settings_image[<?= htmlspecialchars($s['key']) ?>]"
                                               accept="image/*"
                                               class="text-xs font-mono text-[#666] file:mr-4 file:py-2 file:px-4 file:border file:border-[#333] file:bg-[#111] file:text-[#999] file:hover:bg-[#CCFF00] file:hover:text-[#0a0a0a] cursor-pointer file:font-mono file:text-xs">
                                    </div>
                                <?php elseif (strlen($s['value']) > 80 || strpos($s['value'], "\n") !== false): ?>
                                    <textarea name="settings[<?= htmlspecialchars($s['key']) ?>]"
                                              rows="3"
                                              class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] resize-y"><?= htmlspecialchars($s['value']) ?></textarea>
                                <?php else: ?>
                                    <input type="text"
                                           name="settings[<?= htmlspecialchars($s['key']) ?>]"
                                           value="<?= htmlspecialchars($s['value']) ?>"
                                           class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
                                <?php endif; ?>
                                <p class="text-[10px] font-mono text-[#333] mt-1"><?= htmlspecialchars($s['key']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="border-t border-[#333] pt-8">
                <button type="submit"
                        class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white">
                    [ SAVE ALL SETTINGS ]
                </button>
            </div>
        </form>
    <?php endif; ?>
</section>
