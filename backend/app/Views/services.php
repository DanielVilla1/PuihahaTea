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
                        <article class="group bg-white shadow-sm rounded-xl ring-1 ring-emerald-100 overflow-hidden">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                <img src="<?= htmlspecialchars($p['img'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($p['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover group-hover:scale-[1.03] transition duration-300" />
                                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent pointer-events-none"></div>
                            </div>
                            <div class="p-5">
                                <h3 class="font-serif text-emerald-900 text-xl"><?= htmlspecialchars($p['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>
                                <p class="mt-1 text-emerald-800/80"><?= htmlspecialchars($p['desc'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-emerald-700/90">Tropical Blend</span>
                                    <button class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white">View</button>
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

</html>