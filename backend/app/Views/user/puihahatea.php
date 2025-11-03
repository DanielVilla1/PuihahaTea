<?php /* View: PuihahaTea landing page - Tropic vibes */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="bg-gradient-to-b from-emerald-50 via-lime-50 to-amber-50 min-h-dvh text-gray-800">
    <!-- Nav -->
    <?= $this->include('components/public_nav') ?>

    <main id="home" class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <!-- Hero -->
        <section class="isolate relative py-16 sm:py-20 lg:py-28 overflow-hidden">
            <div class="-z-10 absolute inset-0 overflow-hidden pointer-events-none">
                <div class="top-24 left-0 absolute bg-emerald-200/40 blur-2xl rounded-full w-72 h-72"></div>
                <div class="top-32 right-0 absolute bg-amber-200/40 blur-2xl rounded-full w-72 h-72"></div>
                <div class="right-1/3 bottom-8 absolute bg-lime-200/40 blur-2xl rounded-full w-72 h-72"></div>
            </div>
            <div class="items-center gap-10 grid md:grid-cols-2">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 bg-white/70 px-3 py-1 rounded-full ring-1 ring-emerald-100 text-emerald-900/80 text-sm">
                        <span>New</span>
                        <span class="bg-emerald-400 rounded-full w-1 h-1"></span>
                        <span>Tropical Seasonal Blends</span>
                    </div>
                    <h1 class="font-serif text-emerald-900 text-4xl sm:text-5xl lg:text-6xl leading-tight">
                        Taste the Tropics in Every Sip
                    </h1>
                    <p class="text-emerald-800/80 text-lg sm:text-xl">
                        Refreshing blends brewed from premium leaves, real fruit, and a splash of island sunshine.
                    </p>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="/services" class="bg-emerald-600 hover:bg-emerald-700 px-5 py-3 rounded-md text-white">Explore Services</a>
                        <a href="/contact" class="bg-white hover:bg-emerald-50 px-5 py-3 rounded-md ring-1 ring-emerald-200 text-emerald-800">Order for Events</a>
                        <a href="/about" class="px-5 py-3 text-emerald-800/80 hover:text-emerald-900">Learn More</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="-z-10 absolute -inset-4 bg-gradient-to-tr from-emerald-200 via-lime-200 to-amber-200 opacity-60 blur-xl rounded-2xl"></div>
                    <img src="https://images.nationalgeographic.org/image/upload/v1638887255/EducationHub/photos/day-in-the-tropics.jpg" alt="Tropical tea with citrus and mint" class="shadow-xl rounded-2xl ring-1 ring-emerald-200/50 w-full" />
                </div>
            </div>
        </section>

        <!-- Services -->
        <section id="services" class="py-16 sm:py-20 lg:py-24">
            <h2 class="font-serif text-emerald-900 text-3xl sm:text-4xl">Services</h2>
            <p class="mt-2 max-w-2xl text-emerald-800/80">From custom blends to event bars, we bring tropical tea joy to any moment.</p>
            <div class="gap-6 grid sm:grid-cols-2 lg:grid-cols-3 mt-10">
                <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <h3 class="font-serif text-emerald-900 text-2xl">Custom Blends</h3>
                    <p class="mt-2 text-emerald-800/80">Create your signature tea with island fruits, herbs, and florals.</p>
                </div>
                <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <h3 class="font-serif text-emerald-900 text-2xl">Tea Bar Catering</h3>
                    <p class="mt-2 text-emerald-800/80">Pop-up tea bars for weddings, launches, and private events.</p>
                </div>
                <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <h3 class="font-serif text-emerald-900 text-2xl">Workshops</h3>
                    <p class="mt-2 text-emerald-800/80">Hands-on sessions on brewing, pairing, and tropical mixology.</p>
                </div>
            </div>
        </section>

        <!-- Featured Blends -->
        <?php $featured = $featured ?? []; ?>
        <?php if (! empty($featured)) : ?>
            <section class="py-16 sm:py-20 lg:py-24">
                <div class="flex justify-between items-end gap-2">
                    <div>
                        <h2 class="font-serif text-emerald-900 text-3xl sm:text-4xl">Featured Blends</h2>
                        <p class="mt-2 max-w-2xl text-emerald-800/80">A taste of our best-sellers. See the full gallery on Services.</p>
                    </div>
                    <a href="/services" class="hidden sm:inline-block hover:bg-emerald-50 px-4 py-2 rounded-md ring-1 ring-emerald-200 text-emerald-800">View All</a>
                </div>
                <div class="gap-6 grid sm:grid-cols-2 lg:grid-cols-3 mt-8">
                    <?php foreach ($featured as $p): ?>
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
                        <article class="bg-white shadow-sm rounded-xl ring-1 ring-emerald-100 overflow-hidden">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                <img src="<?= $img ?>" alt="<?= $title ?>" class="w-full h-full object-cover" />
                                <?php if ($price !== ''): ?>
                                    <span class="top-3 left-3 absolute bg-white/90 px-2 py-0.5 rounded ring-1 ring-emerald-100 text-emerald-900 text-sm">₱<?= $price ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="p-5">
                                <h3 class="font-serif text-emerald-900 text-xl"><?= $title ?></h3>
                                <p class="mt-1 text-emerald-800/80 line-clamp-2"><?= $desc ?></p>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs ring-1 <?= $stock > 0 ? 'bg-emerald-50 ring-emerald-100 text-emerald-900/80' : 'bg-rose-50 ring-rose-100 text-rose-900/80' ?>"><?= $stockLabel ?></span>
                                    <a href="/services" class="hover:bg-emerald-50 px-3 py-1.5 rounded-md ring-1 ring-emerald-200 text-emerald-800">See details</a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
                <div class="sm:hidden mt-6 text-center">
                    <a href="/services" class="inline-block hover:bg-emerald-50 px-4 py-2 rounded-md ring-1 ring-emerald-200 text-emerald-800">View All</a>
                </div>
            </section>
        <?php endif; ?>

        <!-- About -->
        <section id="about" class="py-16 sm:py-20 lg:py-24">
            <div class="items-center gap-10 grid md:grid-cols-2">
                <div class="space-y-4 order-last md:order-first">
                    <h2 class="font-serif text-emerald-900 text-3xl sm:text-4xl">About PuihahaTea</h2>
                    <p class="text-emerald-800/80">Born on warm shores and perfected with care, we blend tradition with tropical flair. Every cup celebrates freshness, balance, and delight.</p>
                    <ul class="space-y-2 pl-5 text-emerald-900/80 list-disc">
                        <li>Sustainably sourced leaves</li>
                        <li>Real fruits and botanicals</li>
                        <li>Small-batch crafted</li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="-z-10 absolute -inset-4 bg-gradient-to-tr from-emerald-200 via-lime-200 to-amber-200 opacity-60 blur-xl rounded-2xl"></div>
                    <img src="https://images.unsplash.com/photo-1497534446932-c925b458314e?q=80&w=1400&auto=format&fit=crop" alt="Fresh tea leaves and tropical fruits" class="shadow-lg rounded-2xl ring-1 ring-emerald-200/50 w-full" />
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="py-16 sm:py-20 lg:py-24">
            <h2 class="font-serif text-emerald-900 text-3xl sm:text-4xl">What people say</h2>
            <div class="gap-6 grid sm:grid-cols-2 lg:grid-cols-3 mt-8">
                <blockquote class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <p class="text-emerald-900/90">“The Mango Breeze Oolong was the star of our event—refreshing and unique!”</p>
                    <footer class="mt-3 text-emerald-800/70 text-sm">— Althea, Events Planner</footer>
                </blockquote>
                <blockquote class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <p class="text-emerald-900/90">“Loved the pop-up tea bar. Professional, fun, and delicious drinks.”</p>
                    <footer class="mt-3 text-emerald-800/70 text-sm">— Marco, Groom</footer>
                </blockquote>
                <blockquote class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <p class="text-emerald-900/90">“Their hibiscus cooler is my new favorite. Bright, tart, and balanced.”</p>
                    <footer class="mt-3 text-emerald-800/70 text-sm">— Dana, Food Blogger</footer>
                </blockquote>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="py-16 sm:py-20 lg:py-24">
            <h2 class="font-serif text-emerald-900 text-3xl sm:text-4xl">Contact Us</h2>
            <p class="mt-2 max-w-2xl text-emerald-800/80">Let’s plan your next refreshing moment. We’ll get back within 1–2 business days.</p>
            <div class="bg-white shadow-sm mt-8 p-6 sm:p-8 border border-emerald-100 rounded-2xl ring-1 ring-emerald-100">
                <form class="gap-4 grid sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Name</label>
                        <input type="text" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="Your name" />
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Email</label>
                        <input type="email" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="you@example.com" />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block font-medium text-emerald-900/80 text-sm">Message</label>
                        <textarea rows="4" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="Tell us about your event or idea..."></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <button type="button" class="bg-emerald-700 hover:bg-emerald-800 px-5 py-3 rounded-md text-white">Send Message</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer class="bg-white/70 mt-24 border-emerald-100 border-t">
        <div class="flex sm:flex-row flex-col justify-between items-center gap-4 mx-auto px-4 sm:px-6 lg:px-8 py-8 max-w-6xl text-emerald-900/70 text-sm">
            <p>© <?php echo date('Y'); ?> PuihahaTea. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-emerald-900">Instagram</a>
                <a href="#" class="hover:text-emerald-900">Facebook</a>
                <a href="#" class="hover:text-emerald-900">X</a>
            </div>
        </div>
    </footer>

    <script>
        // simple mobile menu toggle
        const btn = document.getElementById('navToggle');
        const menu = document.getElementById('mobileMenu');
        if (btn && menu) {
            btn.addEventListener('click', () => {
                const open = menu.classList.contains('hidden');
                menu.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', String(open));
            });
        }
    </script>
</body>

</html>