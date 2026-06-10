<section class="border-b border-[#333] px-6 lg:px-12 py-10 max-w-3xl">
    <a href="/admin/articles" class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline mb-6 inline-block">[ BACK TO ARTICLES ]</a>
    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mt-4">[ ARTICLES ]</p>
    <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">EDIT <span class="text-[#CCFF00]">ARTICLE</span></h1>

    <?php if (!empty($error)): ?>
        <div class="border border-[#333] px-4 py-3 mt-6"><p class="text-xs font-mono text-[#666]"><?= htmlspecialchars($error) ?></p></div>
    <?php endif; ?>

    <form method="POST" action="/admin/articles/edit?id=<?= $article['id'] ?>" enctype="multipart/form-data" class="mt-8 space-y-6">
        <div>
            <label for="title" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ TITLE ]</label>
            <input type="text" id="title" name="title" required value="<?= htmlspecialchars($article['title']) ?>" oninput="slugify(this.value)" class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline">
        </div>
        <div>
            <label for="slug" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ SLUG ]</label>
            <input type="text" id="slug" name="slug" value="<?= htmlspecialchars($article['slug']) ?>" class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline">
        </div>
        <div>
            <label for="content" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ CONTENT ]</label>
            <textarea id="content" name="content" rows="16" required class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] resize-y no-underline"><?= htmlspecialchars($article['content']) ?></textarea>
        </div>
        <div>
            <label for="status" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ STATUS ]</label>
            <select id="status" name="status" class="w-full bg-[#0a0a0a] border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline">
                <option value="draft" <?= $article['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                <option value="published" <?= $article['status'] === 'published' ? 'selected' : '' ?>>Published</option>
                <option value="archived" <?= $article['status'] === 'archived' ? 'selected' : '' ?>>Archived</option>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ CURRENT IMAGE ]</label>
            <?php if (!empty($article['image'])): ?>
                <div class="border border-[#333] p-2 inline-block"><img src="/<?= htmlspecialchars($article['image']) ?>" alt="" class="h-24 object-contain grayscale"></div>
            <?php else: ?>
                <p class="text-xs font-mono text-[#333]">No image</p>
            <?php endif; ?>
        </div>
        <div>
            <label for="image" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ REPLACE IMAGE ]</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="w-full text-xs font-mono text-[#666] file:mr-4 file:py-2 file:px-4 file:border file:border-[#333] file:bg-transparent file:text-[10px] file:font-mono file:text-[#CCFF00] file:uppercase file:tracking-[.2em] file:cursor-pointer hover:file:bg-[#111] no-underline">
            <p class="text-[10px] font-mono text-[#333] mt-2">Accepted: JPG, PNG, GIF, WebP — Max 2MB</p>
        </div>
        <div class="flex items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white no-underline">UPDATE ARTICLE</button>
            <a href="/admin/articles/delete?id=<?= $article['id'] ?>" class="px-6 py-3 border border-[#333] text-[#666] text-xs tracking-[.2em] uppercase font-mono hover:border-white hover:text-white no-underline" onclick="return confirm('Delete this article?')">DELETE</a>
        </div>
    </form>
</section>

<script>
function slugify(val) {
    var slug = document.getElementById('slug');
    if (!slug.dataset.dirty) slug.value = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
}
document.getElementById('slug').addEventListener('input', function(){ this.dataset.dirty = '1'; });
</script>
