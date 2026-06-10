<div class="max-w-4xl mx-auto px-6 lg:px-10 py-10">
    <div class="mb-10">
        <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ CMS ]</p>
        <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">SITE SETTINGS</h1>
    </div>

    <?php if (!empty($success)): ?>
        <div class="border border-[#CCFF00] px-4 py-3 mb-8">
            <p class="text-[11px] font-mono text-[#CCFF00]">[ OK ] <?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= baseUrl('/admin/settings') ?>" class="space-y-12">
        <?php
        $groupOrder = ['general', 'landing', 'about', 'services', 'contact'];
        $groupLabels = [
            'general' => 'GENERAL',
            'landing' => 'LANDING PAGE',
            'about' => 'ABOUT PAGE',
            'services' => 'SERVICES PAGE',
            'contact' => 'CONTACT PAGE',
        ];
        foreach ($groupOrder as $group):
            if (empty($grouped[$group])) continue;
        ?>
            <div class="border border-[#333] p-6">
                <h2 class="text-xs font-mono text-[#CCFF00] tracking-[.2em] uppercase mb-6">[ <?= $groupLabels[$group] ?? strtoupper($group) ?> ]</h2>
                <div class="space-y-6">
                    <?php foreach ($grouped[$group] as $setting): ?>
                        <div>
                            <label for="setting_<?= htmlspecialchars($setting['setting_key']) ?>" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">
                                [ <?= htmlspecialchars(str_replace('_', ' ', $setting['setting_key'])) ?> ]
                            </label>
                            <?php if (strlen($setting['setting_value'] ?? '') > 100): ?>
                                <textarea id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                          name="settings[<?= htmlspecialchars($setting['setting_key']) ?>]"
                                          rows="4"
                                          class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono leading-relaxed outline-none focus:border-[#CCFF00] resize-vertical rounded-none"><?= htmlspecialchars($setting['setting_value'] ?? '') ?></textarea>
                            <?php else: ?>
                                <input type="text"
                                       id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                       name="settings[<?= htmlspecialchars($setting['setting_key']) ?>]"
                                       value="<?= htmlspecialchars($setting['setting_value'] ?? '') ?>"
                                       class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
                            <?php endif; ?>
                            <?php if (!empty($setting['description'])): ?>
                                <p class="mt-1 text-[10px] font-mono text-[#333]"><?= htmlspecialchars($setting['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php
        // Render any remaining groups not in $groupOrder
        foreach ($grouped as $group => $settings):
            if (in_array($group, $groupOrder)) continue;
        ?>
            <div class="border border-[#333] p-6">
                <h2 class="text-xs font-mono text-[#CCFF00] tracking-[.2em] uppercase mb-6">[ <?= htmlspecialchars(strtoupper($group)) ?> ]</h2>
                <div class="space-y-6">
                    <?php foreach ($settings as $setting): ?>
                        <div>
                            <label for="setting_<?= htmlspecialchars($setting['setting_key']) ?>" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">
                                [ <?= htmlspecialchars(str_replace('_', ' ', $setting['setting_key'])) ?> ]
                            </label>
                            <?php if (strlen($setting['setting_value'] ?? '') > 100): ?>
                                <textarea id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                          name="settings[<?= htmlspecialchars($setting['setting_key']) ?>]"
                                          rows="4"
                                          class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono leading-relaxed outline-none focus:border-[#CCFF00] resize-vertical rounded-none"><?= htmlspecialchars($setting['setting_value'] ?? '') ?></textarea>
                            <?php else: ?>
                                <input type="text"
                                       id="setting_<?= htmlspecialchars($setting['setting_key']) ?>"
                                       name="settings[<?= htmlspecialchars($setting['setting_key']) ?>]"
                                       value="<?= htmlspecialchars($setting['setting_value'] ?? '') ?>"
                                       class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
                            <?php endif; ?>
                            <?php if (!empty($setting['description'])): ?>
                                <p class="mt-1 text-[10px] font-mono text-[#333]"><?= htmlspecialchars($setting['description']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                    class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white rounded-none">
                [ SAVE ]
            </button>
            <a href="<?= baseUrl('/admin') ?>" class="px-8 py-3 border border-[#333] text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ CANCEL ]</a>
        </div>
    </form>
</div>
