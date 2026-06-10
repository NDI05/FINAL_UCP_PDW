<section class="border-b border-[#333] px-6 lg:px-12 py-10 max-w-3xl">
    <a href="/admin/users" class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline mb-6 inline-block">[ BACK TO USERS ]</a>
    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mt-4">[ USERS ]</p>
    <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">CREATE <span class="text-[#CCFF00]">USER</span></h1>

    <?php if (!empty($error)): ?>
        <div class="border border-[#333] px-4 py-3 mt-6">
            <p class="text-xs font-mono text-[#666]"><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/users/create" class="mt-8 space-y-6">
        <div>
            <label for="username" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ USERNAME ]</label>
            <input type="text" id="username" name="username" required
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
        </div>
        <div>
            <label for="email" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ EMAIL ]</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
        </div>
        <div>
            <label for="password" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ PASSWORD ]</label>
            <input type="password" id="password" name="password" required
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
        </div>
        <div>
            <label for="role" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ ROLE ]</label>
            <select id="role" name="role"
                    class="w-full bg-[#0a0a0a] border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
                <option value="editor" <?= (($_POST['role'] ?? 'editor') === 'editor') ? 'selected' : '' ?>>Editor</option>
                <option value="admin"  <?= (($_POST['role'] ?? '') === 'admin') ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white">
                [ CREATE USER ]
            </button>
            <a href="/admin/users"
               class="px-6 py-3 border border-[#333] text-[#666] text-xs tracking-[.2em] uppercase font-mono hover:border-white hover:text-white no-underline">
                CANCEL
            </a>
        </div>
    </form>
</section>
