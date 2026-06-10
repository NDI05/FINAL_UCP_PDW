<section class="relative border-b border-[#333] py-20 md:py-24 lg:py-32 overflow-hidden">
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none select-none overflow-hidden">
        <span class="text-[10rem] sm:text-[16rem] md:text-[18rem] lg:text-[22rem] font-black text-white/[0.03] leading-none">SYS</span>
    </div>
    <div class="relative z-10 max-w-5xl mx-auto px-6 lg:px-12">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4 text-center" data-scroll-reveal>[ ABOUT ]</p>
        <p class="text-xs sm:text-sm font-mono text-[#CCFF00] tracking-[.3em] uppercase mb-8 text-center" data-scroll-reveal>[ <?= strtoupper(htmlspecialchars(SiteSetting::get('about_tagline', 'WE ARE NOT CONSULTANTS. WE ARE NAVIGATORS.'))) ?> ]</p>
        <p class="text-base sm:text-lg md:text-lg lg:text-xl font-light uppercase tracking-[.15em] leading-relaxed text-center max-w-4xl mx-auto" data-scroll-reveal>
            <?= strtoupper(htmlspecialchars(SiteSetting::get('about_intro', 'FOUNDED IN THE ARCHIPELAGO, NUSA DATA INDONESIA EXISTS AT THE INTERSECTION OF DATA SCIENCE, STRATEGIC CONSULTING, AND LOCAL INTELLIGENCE.'))) ?>
        </p>
    </div>
</section>

<section class="border-b border-[#333] py-16 md:py-20 lg:py-24 px-6 md:px-10 lg:px-12">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-10 md:gap-16 lg:gap-20">
            <div><p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-6" data-scroll-reveal>[ ORIGIN ]</p><p class="text-sm sm:text-base font-light leading-relaxed text-[#ccc]" data-scroll-reveal>Founded in Yogyakarta in 2026, NDI emerged from a simple observation: the digital landscape of Indonesia was growing fast, but the quality of its underlying architecture was not keeping pace. We set out to change that — one system, one interface, one connection at a time.</p></div>
            <div><p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-6" data-scroll-reveal>[ APPROACH ]</p><p class="text-sm sm:text-base font-light leading-relaxed text-[#ccc]" data-scroll-reveal>We reject shortcuts. Every line of code is written with intention, every design decision is tested against reality, and every architecture is built to scale. Our process is methodical, our standards are absolute, and our commitment to quality is <span class="text-[#CCFF00]">non-negotiable</span>.</p></div>
        </div>
    </div>
</section>

<section class="border-b border-[#333] py-16 md:py-20 lg:py-24 px-6 md:px-10 lg:px-12">
    <div class="max-w-6xl mx-auto">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-10 text-center" data-scroll-reveal>[ CORE VALUES ]</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 grid-border">
            <div class="p-6 lg:p-8"><span class="text-sm font-mono text-[#CCFF00]">VAL-001</span><h3 class="text-base font-display font-bold uppercase tracking-[.1em] text-white mt-3">Precision</h3><p class="text-[11px] font-mono text-[#666] mt-3 leading-relaxed">Every pixel, every query, every packet — executed with exacting standards.</p></div>
            <div class="p-6 lg:p-8"><span class="text-sm font-mono text-[#CCFF00]">VAL-002</span><h3 class="text-base font-display font-bold uppercase tracking-[.1em] text-white mt-3">Scale</h3><p class="text-[11px] font-mono text-[#666] mt-3 leading-relaxed">Architecture designed to grow with ambition, not replaced by it.</p></div>
            <div class="p-6 lg:p-8"><span class="text-sm font-mono text-[#CCFF00]">VAL-003</span><h3 class="text-base font-display font-bold uppercase tracking-[.1em] text-white mt-3">Clarity</h3><p class="text-[11px] font-mono text-[#666] mt-3 leading-relaxed">Complex systems made simple. No ambiguity, no abstraction without purpose.</p></div>
            <div class="p-6 lg:p-8"><span class="text-sm font-mono text-[#CCFF00]">VAL-004</span><h3 class="text-base font-display font-bold uppercase tracking-[.1em] text-white mt-3">Commitment</h3><p class="text-[11px] font-mono text-[#666] mt-3 leading-relaxed">We finish what we start. Every project ships, every system runs.</p></div>
        </div>
    </div>
</section>

<section class="border-b border-[#333] py-16 md:py-20 lg:py-24 px-6 md:px-10 lg:px-12">
    <div class="max-w-6xl mx-auto">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-10 text-center" data-scroll-reveal>[ TEAM ]</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-0 border border-[#333]">
            <?php 
            $allMembers = TeamMember::getAll();
            $totalMembers = count($allMembers);
            $i = 1;
            foreach ($allMembers as $m): 
                $name = $m['name'];
                $role = $m['role'];
                $img = $m['image'];
                $imgUrl = !empty($img) ? (str_starts_with($img, 'http') ? $img : '/' . $img) : '';
                
                $isLastInRow = ($i % 3 === 0);
                $isLastRow = ($i > ($totalMembers - ($totalMembers % 3 ?: 3)));
                $borderClasses = 'border-[#333] border-b ';
                if (!$isLastInRow && $i < $totalMembers) {
                    $borderClasses .= 'sm:border-r ';
                }
                if ($isLastRow) {
                    $borderClasses .= 'sm:border-b-0 ';
                }
            ?>
                <div class="<?= trim($borderClasses) ?>">
                    <div class="aspect-square bg-[#111] overflow-hidden">
                        <?php if ($imgUrl): ?>
                            <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($name) ?>" class="w-full h-full object-cover grayscale opacity-80" loading="lazy">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center bg-[#222]"><span class="text-[10px] font-mono text-[#333]">[ NO PHOTO ]</span></div>
                        <?php endif; ?>
                    </div>
                    <div class="p-4 lg:p-5 border-t border-[#333]">
                        <p class="text-xs font-mono text-[#666] uppercase tracking-[.2em]"><?= htmlspecialchars($role) ?></p>
                        <h3 class="text-sm font-display font-bold uppercase tracking-[.1em] text-white mt-1"><?= htmlspecialchars($name) ?></h3>
                    </div>
                </div>
            <?php $i++; endforeach; ?>
        </div>
    </div>
</section>
