<div class="max-w-4xl mx-auto px-6 lg:px-10 py-10">
    <div class="mb-10">
        <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ ADMIN ]</p>
        <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">CREATE USER</h1>
    </div>

    <?php if (!empty($error)): ?>
        <div class="border border-[#CCFF00] px-4 py-3 mb-8">
            <p class="text-[11px] font-mono text-[#CCFF00]">[ ERROR ] <?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" action="/admin/users/create" class="space-y-8">
        <div>
            <label for="username" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ USERNAME ]</label>
            <input type="text" id="username" name="username" required
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
        </div>

        <div>
            <label for="email" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ EMAIL ]</label>
            <input type="email" id="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
        </div>

        <div>
            <label for="password" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ PASSWORD ]</label>
            <input type="password" id="password" name="password" required
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
        </div>

        <div>
            <label for="role" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ ROLE ]</label>
            <select id="role" name="role"
                    class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] rounded-none">
                <option value="editor" <?= ($_POST['role'] ?? '') === 'editor' ? 'selected' : '' ?> class="bg-[#0a0a0a]">EDITOR</option>
                <option value="admin" <?= ($_POST['role'] ?? '') === 'admin' ? 'selected' : '' ?> class="bg-[#0a0a0a]">ADMIN</option>
            </select>
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit"
                    class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white rounded-none">
                CREATE
            </button>
            <a href="/admin/users" class="px-8 py-3 border border-[#333] text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ CANCEL ]</a>
        </div>
    </form>
</div>
