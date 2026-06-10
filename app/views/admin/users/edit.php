<section class="border-b border-[#333] px-6 lg:px-12 py-10 max-w-3xl">
    <a href="/admin/users" class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase hover:text-white no-underline mb-6 inline-block">[ BACK TO USERS ]</a>
    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mt-4">[ USERS ]</p>
    <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight mt-2">EDIT <span class="text-[#CCFF00]">USER</span></h1>

    <!-- Read-only info -->
    <div class="mt-8 border border-[#333] px-4 py-4 space-y-3">
        <div>
            <p class="text-[10px] font-mono text-[#333] tracking-[.2em] uppercase mb-1">[ USERNAME ]</p>
            <p class="text-sm font-mono text-white"><?= htmlspecialchars($user['username']) ?></p>
        </div>
        <div class="border-t border-[#222] pt-3">
            <p class="text-[10px] font-mono text-[#333] tracking-[.2em] uppercase mb-1">[ EMAIL ]</p>
            <p class="text-sm font-mono text-[#666]"><?= htmlspecialchars($user['email']) ?></p>
        </div>
    </div>

    <form method="POST" action="/admin/users/edit?id=<?= (int)$user['id'] ?>" class="mt-6 space-y-6">
        <div>
            <label for="role" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ ROLE ]</label>
            <select id="role" name="role"
                    class="w-full bg-[#0a0a0a] border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00]">
                <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                <option value="admin"  <?= $user['role'] === 'admin'  ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <div>
            <label for="password" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ NEW PASSWORD ]</label>
            <input type="password" id="password" name="password"
                   placeholder="Leave blank to keep current"
                   class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] placeholder-[#333]">
            <p class="text-[10px] font-mono text-[#333] mt-2">Leave blank to keep the existing password.</p>
        </div>
        <div class="flex items-center gap-4">
            <button type="submit"
                    class="px-8 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white">
                [ SAVE CHANGES ]
            </button>
            <a href="/admin/users"
               class="px-6 py-3 border border-[#333] text-[#666] text-xs tracking-[.2em] uppercase font-mono hover:border-white hover:text-white no-underline">
                CANCEL
            </a>
        </div>
    </form>
</section>
