<section class="border-b border-[#333] px-6 md:px-10 lg:px-12 py-20 md:py-24 lg:py-28">
    <div class="max-w-6xl mx-auto">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4 text-center" data-scroll-reveal>[ CAPABILITIES ]</p>
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white text-center tracking-tight" data-scroll-reveal>AVAILABLE <span class="text-[#CCFF00]">SERVICES</span></h1>
        <?php if ($intro = SiteSetting::get('services_intro')): ?>
            <p class="text-xs sm:text-sm font-mono text-[#999] tracking-wider uppercase text-center mt-6 max-w-xl mx-auto leading-relaxed" data-scroll-reveal>
                <?= htmlspecialchars($intro) ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<?php
$services = Service::getAll();
$index = 0;
foreach ($services as $s):
    $title = $s['title'];
    $desc = $s['description'];
    $img = $s['image'];
    $imgUrl = !empty($img) ? (str_starts_with($img, 'http') ? $img : '/' . $img) : '';
    $svcCode = 'SVC-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT);
    $isEven = ($index % 2 === 0);
?>
    <section class="border-b border-[#333]">
        <div class="grid grid-cols-1 lg:grid-cols-2">
            <?php if ($isEven): ?>
                <!-- Image on Left, Text on Right -->
                <div class="border-b lg:border-b-0 lg:border-r border-[#333]">
                    <div data-parallax class="h-48 md:h-60 lg:h-72 bg-[#111] overflow-hidden">
                        <?php if ($imgUrl): ?>
                            <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($title) ?>" class="w-full h-full object-cover grayscale opacity-80" loading="lazy">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center"><span class="text-[10px] font-mono text-[#333]">[ NO IMAGE ]</span></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="p-6 md:p-8 lg:p-10 flex flex-col justify-center">
                    <span class="text-[10px] font-mono text-[#CCFF00] tracking-[.2em]"><?= $svcCode ?></span>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white uppercase tracking-[.05em] mt-2"><?= htmlspecialchars($title) ?></h2>
                    <div class="w-10 h-[1px] bg-[#CCFF00] mt-4"></div>
                    <p class="text-sm font-light text-[#999] mt-4 leading-relaxed max-w-md"><?= htmlspecialchars($desc) ?></p>
                </div>
            <?php else: ?>
                <!-- Text on Left, Image on Right -->
                <div class="order-2 lg:order-1 p-6 md:p-8 lg:p-10 flex flex-col justify-center">
                    <span class="text-[10px] font-mono text-[#CCFF00] tracking-[.2em]"><?= $svcCode ?></span>
                    <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white uppercase tracking-[.05em] mt-2"><?= htmlspecialchars($title) ?></h2>
                    <div class="w-10 h-[1px] bg-[#CCFF00] mt-4"></div>
                    <p class="text-sm font-light text-[#999] mt-4 leading-relaxed max-w-md"><?= htmlspecialchars($desc) ?></p>
                </div>
                <div class="order-1 lg:order-2 border-b lg:border-b-0 lg:border-l border-[#333]">
                    <div data-parallax class="h-48 md:h-60 lg:h-72 bg-[#111] overflow-hidden">
                        <?php if ($imgUrl): ?>
                            <img src="<?= htmlspecialchars($imgUrl) ?>" alt="<?= htmlspecialchars($title) ?>" class="w-full h-full object-cover grayscale opacity-80" loading="lazy">
                        <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center"><span class="text-[10px] font-mono text-[#333]">[ NO IMAGE ]</span></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php 
    $index++; 
endforeach; 
?>

<section class="border-b border-[#333] py-16 md:py-18 lg:py-20 text-center px-6">
    <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-6" data-scroll-reveal>[ NEED A CUSTOM SOLUTION? ]</p>
    <a href="<?= baseUrl('/contact') ?>" class="inline-block px-10 py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-sm tracking-[.2em] uppercase font-mono hover:bg-white no-underline" data-scroll-reveal>REQUEST PROPOSAL</a>
</section>
