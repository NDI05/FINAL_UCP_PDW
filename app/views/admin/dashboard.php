<?php
// Dashboard data
$totalArticles = Article::count();
$publishedArticles = Article::countByStatus('published');
$totalContacts = Contact::count();

// Visitors today — raw query
$db = getDB();
$visitorResult = $db->query("SELECT COUNT(*) AS cnt FROM visitors WHERE DATE(visited_at) = CURDATE()");
$visitorsToday = (int)($visitorResult->fetch_assoc()['cnt'] ?? 0);

// Recent data
$recentArticles = Article::getAll(1, 5);
$recentContacts = Contact::getAll(1, 5);

$pageTitle = 'Dashboard';
?>

<div class="max-w-6xl mx-auto px-6 lg:px-10 py-10">
    <div class="mb-10">
        <p class="text-[10px] font-mono text-[#666] tracking-[.3em] uppercase">[ ADMIN ]</p>
        <h1 class="text-2xl lg:text-3xl font-bold text-white tracking-tight mt-1">DASHBOARD</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-12">
        <div class="bg-[#111] border border-[#333] p-5">
            <p class="text-3xl lg:text-4xl font-bold text-[#CCFF00] font-mono"><?= $totalArticles ?></p>
            <p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mt-2">Total Articles</p>
        </div>
        <div class="bg-[#111] border border-[#333] p-5">
            <p class="text-3xl lg:text-4xl font-bold text-[#CCFF00] font-mono"><?= $publishedArticles ?></p>
            <p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mt-2">Published</p>
        </div>
        <div class="bg-[#111] border border-[#333] p-5">
            <p class="text-3xl lg:text-4xl font-bold text-[#CCFF00] font-mono"><?= $totalContacts ?></p>
            <p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mt-2">Total Contacts</p>
        </div>
        <div class="bg-[#111] border border-[#333] p-5">
            <p class="text-3xl lg:text-4xl font-bold text-[#CCFF00] font-mono"><?= $visitorsToday ?></p>
            <p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mt-2">Visitors Today</p>
        </div>
    </div>

    <!-- Recent Articles & Contacts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Articles -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xs font-mono text-[#666] tracking-[.2em] uppercase">[ Recent Articles ]</h2>
                <a href="/admin/articles" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">VIEW ALL →</a>
            </div>
            <div class="border border-[#333]">
                <?php if (empty($recentArticles)): ?>
                    <div class="px-4 py-8 text-center text-[10px] font-mono text-[#333] uppercase tracking-[.2em]">No articles yet</div>
                <?php else: ?>
                    <?php foreach ($recentArticles as $i => $article): ?>
                        <div class="<?= $i > 0 ? 'border-t border-[#333]' : '' ?> px-4 py-3 hover:bg-[#111]">
                            <div class="flex items-center justify-between">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-display font-semibold text-white truncate"><?= htmlspecialchars($article['title']) ?></p>
                                    <p class="text-[10px] font-mono text-[#333] mt-1"><?= date('d/m/y', strtotime($article['created_at'])) ?></p>
                                </div>
                                <?php $status = $article['status']; ?>
                                <span class="text-[10px] font-mono <?= $status === 'published' ? 'text-[#CCFF00]' : ($status === 'archived' ? 'text-[#666]' : 'text-white/60') ?> ml-3 flex-shrink-0">
                                    [ <?= strtoupper(htmlspecialchars($status)) ?> ]
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Contacts -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xs font-mono text-[#666] tracking-[.2em] uppercase">[ Recent Contacts ]</h2>
                <a href="/admin/contacts" class="text-[10px] font-mono text-[#666] hover:text-white no-underline tracking-[.2em] uppercase">VIEW ALL →</a>
            </div>
            <div class="border border-[#333]">
                <?php if (empty($recentContacts)): ?>
                    <div class="px-4 py-8 text-center text-[10px] font-mono text-[#333] uppercase tracking-[.2em]">No contacts yet</div>
                <?php else: ?>
                    <?php foreach ($recentContacts as $i => $contact): ?>
                        <div class="<?= $i > 0 ? 'border-t border-[#333]' : '' ?> px-4 py-3 hover:bg-[#111]">
                            <div class="flex items-center justify-between">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-display font-semibold text-white truncate"><?= htmlspecialchars($contact['name']) ?></p>
                                    <p class="text-[10px] font-mono text-[#666] truncate mt-0.5"><?= htmlspecialchars($contact['email']) ?></p>
                                    <p class="text-[10px] font-mono text-[#333] mt-1"><?= htmlspecialchars($contact['subject'] ?? '') ?> · <?= date('d/m/y', strtotime($contact['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
