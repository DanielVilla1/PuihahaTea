<?php /* View: PuihahaTea landing page - Tropic vibes */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="bg-gradient-to-b from-emerald-50 via-lime-50 to-amber-50 min-h-dvh text-gray-800">
    <!-- Nav -->
    <header class="top-0 z-30 sticky bg-white/80 supports-[backdrop-filter]:bg-white/60 shadow-sm backdrop-blur">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="flex items-center gap-2 font-serif text-emerald-700 text-2xl">
                    <span class="i">🍃</span>
                    <span class="tracking-wide">PuihahaTea</span>
                </a>
                <nav class="hidden md:flex items-center gap-8 text-base">
                    <a href="#home" class="py-2 text-emerald-700 hover:text-emerald-900">Home</a>
                    <a href="/services" class="py-2 text-emerald-700 hover:text-emerald-900">Services</a>
                    <a href="/about" class="py-2 text-emerald-700 hover:text-emerald-900">About</a>
                    <a href="/contact" class="py-2 text-emerald-700 hover:text-emerald-900">Contact</a>
                </nav>
                <button id="navToggle" class="md:hidden inline-flex justify-center items-center p-2 rounded-md text-emerald-700 hover:text-emerald-900" aria-controls="mobileMenu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Mobile menu -->
        <div id="mobileMenu" class="hidden md:hidden border-emerald-100 border-t">
            <div class="space-y-1 px-4 py-3">
                <a href="#home" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700">Home</a>
                <a href="/services" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700">Services</a>
                <a href="/about" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700">About</a>
                <a href="/contact" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700">Contact</a>
            </div>
        </div>
    </header>

    <main id="home" class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <!-- Hero -->
        <section class="py-16 sm:py-20 lg:py-24">
            <div class="items-center gap-10 grid md:grid-cols-2">
                <div class="space-y-6">
                    <h1 class="font-serif text-emerald-900 text-4xl sm:text-5xl lg:text-6xl leading-tight">
                        Taste the Tropics in Every Sip
                    </h1>
                    <p class="text-emerald-800/80 text-lg sm:text-xl">
                        PuihahaTea crafts refreshing tropical tea blends using premium leaves, real fruit, and a splash of island sunshine.
                    </p>
                    <div class="flex gap-3 pt-2">
                        <a href="/services" class="bg-emerald-600 hover:bg-emerald-700 px-5 py-3 rounded-md text-white">Explore Services</a>
                        <a href="/about" class="hover:bg-emerald-700 px-5 py-3 border-2 border-emerald-700 rounded-md text-emerald-700 hover:text-white">Learn More</a>
                    </div>
                </div>
                <div class="relative">
                    <div class="-z-10 absolute -inset-4 bg-gradient-to-tr from-emerald-200 via-lime-200 to-amber-200 opacity-60 blur-xl rounded-2xl"></div>
                    <img src="https://images.nationalgeographic.org/image/upload/v1638887255/EducationHub/photos/day-in-the-tropics.jpg" alt="Tropical tea with citrus and mint" class="shadow-lg rounded-2xl ring-1 ring-emerald-200/50 w-full" />
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