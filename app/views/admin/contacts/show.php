<div class="max-w-4xl mx-auto px-6 lg:px-10 py-10">
    <div class="mb-8">
        <a href="/admin/contacts" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">[ &larr; BACK TO CONTACTS ]</a>
    </div>

    <div class="mb-2">
        <span class="text-[10px] font-mono text-[#333]">ID: <?= (int)$contact['id'] ?></span>
    </div>

    <h1 class="text-3xl lg:text-4xl font-bold text-white tracking-tight mt-2"><?= htmlspecialchars($contact['name']) ?></h1>

    <div class="flex items-center gap-4 mt-4 text-[10px] font-mono text-[#666]">
        <span>[ EMAIL: <?= htmlspecialchars($contact['email']) ?> ]</span>
        <span>[ DATE: <?= date('d M Y, H:i', strtotime($contact['created_at'])) ?> ]</span>
    </div>

    <div class="mt-10 border-t border-[#333] pt-8">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4">[ SUBJECT ]</p>
        <p class="text-sm font-mono text-white"><?= htmlspecialchars($contact['subject']) ?></p>
    </div>

    <div class="mt-8 border-t border-[#333] pt-8">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4">[ MESSAGE ]</p>
        <div class="text-sm font-mono text-[#ccc] leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($contact['message']) ?></div>
    </div>

    <div class="flex items-center gap-4 mt-10 pt-8 border-t border-[#333]">
        <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="px-6 py-2.5 border border-[#333] text-[10px] font-mono text-white hover:border-[#CCFF00] hover:text-[#CCFF00] no-underline tracking-[.2em] uppercase">[ REPLY ]</a>
        <a href="/admin/contacts/delete?id=<?= (int)$contact['id'] ?>" class="px-6 py-2.5 border border-[#333] text-[10px] font-mono text-[#666] hover:border-red-400 hover:text-red-400 no-underline tracking-[.2em] uppercase" onclick="return confirm('Delete this contact?')">[ DELETE ]</a>
    </div>
</div>
