<section class="border-b border-[#333] px-6 lg:px-12 py-10 max-w-3xl">
    <div class="mb-8">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase">[ TEAM CMS ]</p>
        <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">Edit <span class="text-[#CCFF00]">Anggota Tim</span></h1>
    </div>

    <?php if (isset($error)): ?>
        <div class="border border-red-500 px-4 py-3 mb-8">
            <p class="text-xs font-mono text-red-500 tracking-[.1em]">[ ERROR: <?= htmlspecialchars($error) ?> ]</p>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/team/edit?id=<?= $member['id'] ?>" enctype="multipart/form-data" class="space-y-6">
        <div>
            <label for="name" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ MEMBER NAME ]</label>
            <input type="text"
                   id="name"
                   name="name"
                   value="<?= htmlspecialchars($member['name']) ?>"
                   required
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
        </div>

        <div>
            <label for="role" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ ROLE / POSITION ]</label>
            <input type="text"
                   id="role"
                   name="role"
                   value="<?= htmlspecialchars($member['role']) ?>"
                   required
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
        </div>

        <?php if (!empty($member['image'])): 
            $imgUrl = str_starts_with($member['image'], 'http') ? $member['image'] : '/' . $member['image'];
        ?>
            <div>
                <p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ CURRENT PHOTO ]</p>
                <img src="<?= htmlspecialchars($imgUrl) ?>" alt="Current Member Avatar" class="h-28 w-28 rounded-full object-cover border border-[#333] p-1 bg-[#111]">
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="image" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ REPLACE PHOTO ]</label>
                <input type="file"
                       id="image"
                       name="image"
                       accept="image/*"
                       class="w-full text-xs font-mono text-[#666] file:mr-4 file:py-2 file:px-4 file:border file:border-[#333] file:bg-[#111] file:text-[#999] file:hover:bg-[#CCFF00] file:hover:text-[#0a0a0a] cursor-pointer">
            </div>
            <div>
                <label for="order_num" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ ORDER NUMBER ]</label>
                <input type="number"
                       id="order_num"
                       name="order_num"
                       value="<?= (int)$member['order_num'] ?>"
                       class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
            </div>
        </div>

        <div class="border-t border-[#333] pt-6 flex items-center gap-6">
            <button type="submit" class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white transition-all border-0 cursor-pointer">
                [ SAVE CHANGES ]
            </button>
            <a href="/admin/team" class="text-xs font-mono text-[#666] hover:text-white transition-all no-underline">
                [ CANCEL ]
            </a>
        </div>
    </form>
</section>
