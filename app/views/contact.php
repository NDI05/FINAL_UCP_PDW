<section class="border-b border-[#333] px-6 lg:px-12 py-20 lg:py-28">
    <div class="max-w-6xl mx-auto">
        <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-4 text-center" data-scroll-reveal>[ CONNECT ]</p>
        <h1 class="text-2xl sm:text-3xl lg:text-5xl font-bold text-white text-center tracking-tight" data-scroll-reveal>INITIATE <span class="text-[#CCFF00]">CONTACT</span></h1>
    </div>
</section>

<section class="border-b border-[#333]">
    <div class="grid grid-cols-1 lg:grid-cols-2">
        <div class="p-6 lg:p-12 border-b lg:border-b-0 lg:border-r border-[#333]">
            <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-8" data-scroll-reveal>[ SEND MESSAGE ]</p>

            <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                <div class="border border-[#CCFF00] px-4 py-4 mb-6 text-center"><p class="text-xs font-mono text-[#CCFF00] tracking-[.2em] uppercase">[ MESSAGE SENT SUCCESSFULLY ]</p><p class="text-[10px] font-mono text-[#666] mt-1">We will get back to you shortly.</p></div>
            <?php elseif (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
                <div class="border border-[#333] px-4 py-4 mb-6 text-center"><p class="text-xs font-mono text-[#666] tracking-[.2em] uppercase">[ SENDING FAILED ]</p><p class="text-[10px] font-mono text-[#333] mt-1">Please fill in all fields and try again.</p></div>
            <?php endif; ?>

            <form action="<?= baseUrl('/contact') ?>" method="POST" class="space-y-6" data-scroll-reveal>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div><label for="name" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ NAME ]</label><input type="text" id="name" name="name" required class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline"></div>
                    <div><label for="email" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ EMAIL ]</label><input type="email" id="email" name="email" required class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline"></div>
                </div>
                <div><label for="subject" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ SUBJECT ]</label><input type="text" id="subject" name="subject" required class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] no-underline"></div>
                <div><label for="message" class="block text-[10px] font-mono text-[#666] tracking-[.2em] uppercase mb-2">[ MESSAGE ]</label><textarea id="message" name="message" rows="6" required class="w-full bg-transparent border border-[#333] px-4 py-3 text-white text-sm font-mono outline-none focus:border-[#CCFF00] resize-none no-underline"></textarea></div>
                <button type="submit" class="w-full py-3 bg-[#CCFF00] text-[#0a0a0a] font-bold text-xs tracking-[.2em] uppercase font-mono hover:bg-white no-underline">TRANSMIT</button>
            </form>
        </div>

        <div class="p-6 lg:p-12 flex flex-col justify-between">
            <div>
                <p class="text-xs font-mono text-[#666] tracking-[.3em] uppercase mb-8" data-scroll-reveal>[ INFORMATION ]</p>
                <div class="space-y-8" data-scroll-reveal>
                    <div><p class="text-[10px] font-mono text-[#CCFF00] tracking-[.2em] uppercase mb-2">[ EMAIL ]</p><p class="text-sm font-mono text-[#999]"><?= htmlspecialchars(SiteSetting::get('contact_email', 'hello@nusadataindonesia.com')) ?></p></div>
                    <div><p class="text-[10px] font-mono text-[#CCFF00] tracking-[.2em] uppercase mb-2">[ PHONE ]</p><p class="text-sm font-mono text-[#999]"><?= htmlspecialchars(SiteSetting::get('contact_phone', '+62 21 1234 5678')) ?></p></div>
                    <div><p class="text-[10px] font-mono text-[#CCFF00] tracking-[.2em] uppercase mb-2">[ OFFICE ]</p><p class="text-sm font-mono text-[#999] leading-relaxed"><?= nl2br(htmlspecialchars(SiteSetting::get('contact_address', "Jl. Sudirman No. 123\nJakarta Pusat, Indonesia 10220"))) ?></p></div>
                </div>
            </div>
            <div class="mt-10 lg:mt-0 border border-[#333] p-6 min-h-[160px] flex items-center justify-center" data-scroll-reveal><p class="text-[10px] font-mono text-[#333] tracking-[.2em] uppercase">[ MAP INTEGRATION ]</p></div>
        </div>
    </div>
</section>
