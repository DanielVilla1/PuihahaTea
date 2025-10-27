<?php /* View: Services page with product gallery */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Services — PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="bg-gradient-to-b from-emerald-50 via-lime-50 to-amber-50 min-h-dvh text-gray-800">
    <!-- Nav -->
    <header class="top-0 z-30 sticky bg-white/80 supports-[backdrop-filter]:bg-white/60 shadow-sm backdrop-blur">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center gap-2 font-serif text-emerald-700 text-2xl">
                    <span>🍃</span>
                    <span class="tracking-wide">PuihahaTea</span>
                </a>
                <nav class="hidden md:flex items-center gap-8 text-base">
                    <a href="/" class="py-2 text-emerald-700 hover:text-emerald-900">Home</a>
                    <a href="/services" class="py-2 font-semibold text-emerald-900">Services</a>
                    <a href="/about" class="py-2 text-emerald-700 hover:text-emerald-900">About</a>
                    <a href="/contact" class="py-2 text-emerald-700 hover:text-emerald-900">Contact</a>
                </nav>
                <a href="/services" class="md:hidden inline-flex justify-center items-center p-2 rounded-md text-emerald-700 hover:text-emerald-900">
                    <span class="sr-only">Services</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <!-- Heading -->
        <section class="py-12 sm:py-16 lg:py-20">
            <h1 class="font-serif text-emerald-900 text-4xl sm:text-5xl">Our Services</h1>
            <p class="mt-3 max-w-2xl text-emerald-800/80">From custom blends to event bars and workshops, explore our offerings and best-selling tropical tea creations.</p>
        </section>

        <!-- Product Gallery -->
        <section class="pb-16 sm:pb-20 lg:pb-24">
            <h2 class="font-serif text-emerald-900 text-2xl sm:text-3xl">Product Gallery</h2>
            <p class="mt-2 text-emerald-800/80">Signature blends inspired by island botany.</p>
            <div class="gap-6 grid sm:grid-cols-2 lg:grid-cols-3 mt-8">
                <?php $list = $products ?? []; ?>
                <?php if (! empty($list)) : ?>
                    <?php foreach ($list as $p): ?>
                        <?php
                        $title = htmlspecialchars($p['title'] ?? '', ENT_QUOTES, 'UTF-8');
                        $desc  = htmlspecialchars($p['desc'] ?? '', ENT_QUOTES, 'UTF-8');
                        $img   = htmlspecialchars($p['img'] ?? '', ENT_QUOTES, 'UTF-8');
                        $priceRaw = $p['price'] ?? null;
                        $stockRaw = $p['stock'] ?? null;
                        $price = is_numeric($priceRaw) ? number_format((float)$priceRaw, 2) : (is_string($priceRaw) ? htmlspecialchars($priceRaw, ENT_QUOTES, 'UTF-8') : '');
                        $stock = is_numeric($stockRaw) ? (int)$stockRaw : (is_string($stockRaw) ? (int)$stockRaw : 0);
                        $stockLabel = $stock > 0 ? ($stock < 10 ? 'Low stock' : 'In stock') : 'Out of stock';
                        ?>
                        <article class="group bg-white shadow-sm rounded-xl ring-1 ring-emerald-100 overflow-hidden">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                <img src="<?= $img ?>" alt="<?= $title ?>" class="w-full h-full object-cover group-hover:scale-[1.03] transition duration-300" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent pointer-events-none"></div>
                                <?php if ($price !== ''): ?>
                                    <span class="top-3 left-3 absolute bg-white/90 px-2 py-0.5 rounded ring-1 ring-emerald-100 text-emerald-900 text-sm">₱<?= $price ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="p-5">
                                <h3 class="font-serif text-emerald-900 text-xl"><?= $title ?></h3>
                                <p class="mt-1 text-emerald-800/80"><?= $desc ?></p>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-emerald-700/90">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs ring-1 <?= $stock > 0 ? 'bg-emerald-50 ring-emerald-100 text-emerald-900/80' : 'bg-rose-50 ring-rose-100 text-rose-900/80' ?>"><?= $stockLabel ?></span>
                                    </span>
                                    <button
                                        type="button"
                                        class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white"
                                        data-view-product
                                        data-title="<?= $title ?>"
                                        data-desc="<?= $desc ?>"
                                        data-img="<?= $img ?>"
                                        data-price="<?= $price ?>"
                                        data-stock="<?= $stock ?>">View</button>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="sm:col-span-2 lg:col-span-3 bg-white p-6 rounded-xl ring-1 ring-emerald-100 text-emerald-900/80">
                        No products available yet. Please add some items to the catalog.
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- CTA -->
        <section class="bg-emerald-700 mb-20 px-6 py-10 rounded-2xl text-white">
            <h3 class="font-serif text-2xl">Plan an event with PuihahaTea</h3>
            <p class="mt-2 text-emerald-50/90">Tea bar catering, custom favors, and interactive brewing stations for your special day.</p>
            <a href="/contact" class="inline-block bg-white/10 hover:bg-white/20 mt-4 px-5 py-3 rounded-md">Contact Us</a>
        </section>
    </main>

    <!-- Product Modal -->
    <div id="productModal" class="hidden z-50 fixed inset-0" role="dialog" aria-modal="true" aria-labelledby="pmTitle">
        <!-- Overlay -->
        <div id="pmOverlay" class="absolute inset-0 bg-black/40 opacity-0 backdrop-blur-sm transition-opacity duration-200"></div>
        <!-- Dialog wrapper -->
        <div class="relative flex justify-center items-center p-4 sm:p-6 w-full h-full">
            <div id="pmDialog" tabindex="-1" class="bg-white opacity-0 shadow-2xl rounded-2xl ring-1 ring-emerald-100 w-full max-w-3xl overflow-hidden sm:scale-95 transition translate-y-4 sm:translate-y-0 duration-200">
                <div class="grid md:grid-cols-5">
                    <!-- Media -->
                    <div class="relative md:col-span-2 bg-emerald-50">
                        <img id="pmImg" alt="" class="w-full h-full object-cover aspect-[4/3] md:aspect-auto" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent pointer-events-none"></div>
                        <span id="pmPriceBadge" class="hidden top-3 left-3 absolute bg-white/90 px-2 py-0.5 rounded ring-1 ring-emerald-100 text-emerald-900 text-sm"></span>
                    </div>
                    <!-- Body -->
                    <div class="md:col-span-3 p-6">
                        <div class="flex justify-between items-start gap-4">
                            <h3 id="pmTitle" class="font-serif text-emerald-900 text-2xl leading-snug"></h3>
                            <button id="pmClose" type="button" aria-label="Close" class="inline-flex justify-center items-center bg-emerald-50 hover:bg-emerald-100 rounded-full ring-1 ring-emerald-100 w-9 h-9 text-emerald-800 shrink-0">✕</button>
                        </div>
                        <p id="pmDesc" class="mt-3 text-emerald-800/80 leading-relaxed"></p>
                        <div class="flex flex-wrap items-center gap-3 mt-5">
                            <span id="pmPrice" class="hidden md:inline-block bg-emerald-50 px-3 py-1 rounded ring-1 ring-emerald-100 font-medium text-emerald-900/90"></span>
                            <span id="pmStock" class="inline-block px-3 py-1 rounded ring-1 text-sm"></span>
                        </div>
                        <div class="flex flex-wrap gap-3 mt-6">
                            <a href="/contact" class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white">
                                <span>Order now</span>
                            </a>
                            <button type="button" class="inline-flex items-center gap-2 bg-white hover:bg-emerald-50 px-4 py-2 rounded-md ring-1 ring-emerald-100 text-emerald-900 pmCloseBtn">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white/70 mt-10 border-emerald-100 border-t">
        <div class="flex sm:flex-row flex-col justify-between items-center gap-4 mx-auto px-4 sm:px-6 lg:px-8 py-8 max-w-6xl text-emerald-900/70 text-sm">
            <p>© <?= date('Y'); ?> PuihahaTea. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-emerald-900">Instagram</a>
                <a href="#" class="hover:text-emerald-900">Facebook</a>
                <a href="#" class="hover:text-emerald-900">X</a>
            </div>
        </div>
    </footer>
</body>

<script>
    (function() {
        const modal = document.getElementById('productModal');
        const overlay = document.getElementById('pmOverlay');
        const dialog = document.getElementById('pmDialog');
        const pmTitle = document.getElementById('pmTitle');
        const pmDesc = document.getElementById('pmDesc');
        const pmImg = document.getElementById('pmImg');
        const pmPrice = document.getElementById('pmPrice');
        const pmPriceBadge = document.getElementById('pmPriceBadge');
        const pmStock = document.getElementById('pmStock');
        const pmClose = document.getElementById('pmClose');
        let lastFocused = null;

        const open = (data) => {
            pmTitle.textContent = data.title || '';
            pmDesc.textContent = data.desc || '';
            pmImg.src = data.img || '';
            pmImg.alt = data.title || '';
            const priceText = data.price ? `₱${data.price}` : '';
            pmPrice.textContent = priceText;
            pmPrice.classList.toggle('hidden', priceText === '');
            pmPriceBadge.textContent = priceText;
            pmPriceBadge.classList.toggle('hidden', priceText === '');
            const stock = parseInt(data.stock || '0', 10);
            pmStock.textContent = isNaN(stock) ? '' : (stock > 0 ? `${stock} in stock` : 'Out of stock');
            pmStock.className = 'inline-block px-3 py-1 rounded ring-1 text-sm ' + (stock > 0 ? 'bg-emerald-50 ring-emerald-100 text-emerald-900/80' : 'bg-rose-50 ring-rose-100 text-rose-900/80');

            lastFocused = document.activeElement;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // animate in
            requestAnimationFrame(() => {
                overlay && overlay.classList.remove('opacity-0');
                dialog && dialog.classList.remove('opacity-0', 'translate-y-4', 'sm:scale-95');
                // focus close for accessibility
                pmClose && pmClose.focus();
            });
        };
        const close = () => {
            // animate out
            overlay && overlay.classList.add('opacity-0');
            dialog && dialog.classList.add('opacity-0', 'translate-y-4');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
                // reset animation classes for next open
                dialog && dialog.classList.add('sm:scale-95');
                if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
            }, 180);
        };

        document.querySelectorAll('[data-view-product]').forEach(btn => {
            btn.addEventListener('click', () => open({
                title: btn.getAttribute('data-title') || '',
                desc: btn.getAttribute('data-desc') || '',
                img: btn.getAttribute('data-img') || '',
                price: btn.getAttribute('data-price') || '',
                stock: btn.getAttribute('data-stock') || '0',
            }));
        });
        pmClose && pmClose.addEventListener('click', close);
        document.querySelectorAll('.pmCloseBtn').forEach(el => el.addEventListener('click', close));
        modal && modal.addEventListener('mousedown', (e) => {
            // close on backdrop click
            if (e.target === modal || e.target === overlay) close();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
        });
    })();
</script>

</html>