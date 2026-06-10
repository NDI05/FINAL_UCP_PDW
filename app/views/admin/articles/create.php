<section class="border-b border-[#333] px-6 lg:px-12 py-10 max-w-3xl">
    <a href="<?= baseUrl('/admin/articles') ?>" class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline mb-6 inline-block">[ BACK TO ARTICLES ]</a>
    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mt-4">[ ARTICLES ]</p>
    <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">CREATE <span class="text-[#CCFF00]">ARTICLE</span></h1>

    <?php if (!empty($error)): ?>
        <div class="border border-[#333] px-4 py-3 mt-6"><p class="text-xs font-mono text-[#666]"><?= htmlspecialchars($error) ?></p></div>
    <?php endif; ?>

    <form method="POST" action="<?= baseUrl('/admin/articles/create') ?>" enctype="multipart/form-data" class="mt-8 space-y-6">
        <div>
            <label for="title" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ TITLE ]</label>
            <input type="text" id="title" name="title" required oninput="slugify(this.value)" class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline">
        </div>
        <div>
            <label for="slug" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ SLUG ]</label>
            <input type="text" id="slug" name="slug" class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline">
        </div>
        <div>
            <label for="content" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ CONTENT ]</label>
            <textarea id="content" name="content" rows="16" required class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] resize-y no-underline"></textarea>
        </div>
        <div>
            <label for="status" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ STATUS ]</label>
            <select id="status" name="status" class="w-full bg-[#0a0a0a] border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="archived">Archived</option>
            </select>
        </div>
        <div>
            <label for="image" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ IMAGE ]</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="w-full text-xs font-mono text-[#666] file:mr-4 file:py-2 file:px-4 file:border file:border-[#333] file:bg-transparent file:text-[10px] file:font-mono file:text-[#CCFF00] file:uppercase file:tracking-[.2em] file:cursor-pointer hover:file:bg-[#111] no-underline">
            <p class="text-[10px] font-mono text-[#333] mt-2">Accepted: JPG, PNG, GIF, WebP — Max 2MB</p>
        </div>
        <button type="submit" class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white no-underline">PUBLISH ARTICLE</button>
    </form>
</section>

<script>
function slugify(val) {
    var slug = document.getElementById('slug');
    if (!slug.dataset.dirty) slug.value = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
}
document.getElementById('slug').addEventListener('input', function(){ this.dataset.dirty = '1'; });
</script>
