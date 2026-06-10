<div class="max-w-4xl mx-auto px-6 lg:px-10 py-10">
    <div class="mb-10">
        <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ CMS ]</p>
        <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">EDIT TEAM MEMBER</h1>
    </div>

    <?php if (!empty($error)): ?>
        <div class="border border-[#CCFF00] px-4 py-3 mb-8">
            <p class="text-[11px] font-mono text-[#CCFF00]">[ ERROR ] <?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/team/edit?id=<?= (int)$member['id'] ?>" enctype="multipart/form-data" class="space-y-8">
        <div>
            <label for="name" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ NAME ]</label>
            <input type="text" id="name" name="name" required value="<?= htmlspecialchars($member['name']) ?>"
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
        </div>

        <div>
            <label for="role" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ ROLE ]</label>
            <input type="text" id="role" name="role" required value="<?= htmlspecialchars($member['role']) ?>"
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
        </div>

        <div>
            <label class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ CURRENT IMAGE ]</label>
            <?php if (!empty($member['image'])): ?>
                <div class="border border-[#333] p-2 inline-block">
                    <img src="/<?= htmlspecialchars($member['image']) ?>" alt="Current" class="h-32 w-auto grayscale">
                </div>
            <?php else: ?>
                <p class="text-[10px] font-mono text-[#333]">No image</p>
            <?php endif; ?>
        </div>

        <div>
            <label for="image" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ REPLACE IMAGE ]</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp"
                   class="w-full text-sm font-mono text-[#666] file:mr-4 file:py-2 file:px-4 file:border file:border-[#333] file:bg-transparent file:text-[10px] file:font-mono file:text-[#CCFF00] file:uppercase file:tracking-[.2em] hover:file:bg-[#111]">
            <p class="mt-2 text-[10px] font-mono text-[#333]">Leave empty to keep current image</p>
        </div>

        <div>
            <label for="order_num" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ ORDER NUMBER ]</label>
            <input type="number" id="order_num" name="order_num" value="<?= (int)$member['order_num'] ?>" min="0"
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                    class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white rounded-none">
                [ UPDATE ]
            </button>
            <a href="/admin/team" class="px-8 py-3 border border-[#333] text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ CANCEL ]</a>
        </div>
    </form>
</div>
