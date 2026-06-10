<section class="border-b border-[#333] px-6 lg:px-12 py-10 lg:py-14">
    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase" data-scroll-reveal>[ DASHBOARD ]</p>
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white tracking-tight mt-2" data-scroll-reveal>WELCOME, <span class="text-[#CCFF00]"><?= htmlspecialchars($_SESSION['username'] ?? 'ADMIN') ?></span></h1>
</section>

<?php
require_once __DIR__ . '/../../models/Visitor.php';
$todayVisitors = Visitor::getTodayCount();
$totalVisitors = Visitor::getTotalCount();
$topPages = Visitor::getTopPages(5);
$recentVisitors = Visitor::getRecent(10);
?>

<section class="border-b border-[#333] px-6 lg:px-12 py-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="border border-[#333] p-6"><p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase">[ TODAY ]</p><p class="text-3xl font-bold text-[#CCFF00] mt-2"><?= $todayVisitors ?></p><p class="text-[10px] font-mono text-[#666] mt-1">VISITORS</p></div>
        <div class="border border-[#333] p-6"><p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase">[ TOTAL ]</p><p class="text-3xl font-bold text-[#CCFF00] mt-2"><?= $totalVisitors ?></p><p class="text-[10px] font-mono text-[#666] mt-1">ALL TIME</p></div>
        <div class="border border-[#333] p-6"><p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase">[ ARTICLES ]</p><p class="text-3xl font-bold text-[#CCFF00] mt-2"><?= Article::count() ?></p><p class="text-[10px] font-mono text-[#666] mt-1">TOTAL</p></div>
        <div class="border border-[#333] p-6"><p class="text-[10px] font-mono text-[#666] tracking-[.2em] uppercase">[ PUBLISHED ]</p><p class="text-3xl font-bold text-[#CCFF00] mt-2"><?= Article::countByStatus('published') ?></p><p class="text-[10px] font-mono text-[#666] mt-1">ARTICLES</p></div>
    </div>
</section>

<section class="border-b border-[#333] px-6 lg:px-12 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div>
            <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4" data-scroll-reveal>[ TOP PAGES ]</p>
            <div class="border border-[#333]">
                <?php if (empty($topPages)): ?>
                    <p class="p-4 text-xs font-mono text-[#333]">No data yet.</p>
                <?php else: ?>
                    <?php $i = 1; foreach ($topPages as $p): ?>
                        <div class="flex items-center justify-between px-4 py-3 border-b border-[#333] last:border-b-0">
                            <div class="flex items-center gap-3"><span class="text-[10px] font-mono text-[#333]"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></span><span class="text-xs font-mono text-[#999]">/<?= htmlspecialchars($p['page'] === '/' ? 'home' : ltrim($p['page'], '/')) ?></span></div>
                            <span class="text-xs font-mono text-[#CCFF00]"><?= (int)$p['visits'] ?></span>
                        </div>
                    <?php $i++; endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4" data-scroll-reveal>[ RECENT VISITORS ]</p>
            <div class="border border-[#333] max-h-80 overflow-y-auto">
                <?php if (empty($recentVisitors)): ?>
                    <p class="p-4 text-xs font-mono text-[#333]">No data yet.</p>
                <?php else: ?>
                    <?php foreach ($recentVisitors as $v): ?>
                        <div class="px-4 py-2.5 border-b border-[#333] last:border-b-0">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-mono text-[#666]"><?= htmlspecialchars($v['ip_address']) ?></span>
                                <span class="text-[10px] font-mono text-[#333]"><?= date('H:i', strtotime($v['visited_at'])) ?></span>
                            </div>
                            <p class="text-[10px] font-mono text-[#999] mt-0.5">/<?= htmlspecialchars($v['page'] === '/' ? 'home' : ltrim($v['page'], '/')) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
