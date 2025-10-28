<?php /* View: About page with brand history */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'About — PuihahaTea'; ?>
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
                    <a href="/services" class="py-2 text-emerald-700 hover:text-emerald-900">Services</a>
                    <a href="/about" class="py-2 font-semibold text-emerald-900">About</a>
                    <a href="/contact" class="py-2 text-emerald-700 hover:text-emerald-900">Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <!-- Page title -->
        <section class="py-12 sm:py-16 lg:py-20">
            <h1 class="font-serif text-emerald-900 text-4xl sm:text-5xl">About PuihahaTea</h1>
            <p class="mt-3 max-w-2xl text-emerald-800/80">Where tropical sunshine meets the art of tea.</p>
        </section>

        <!-- History timeline -->
        <section class="pb-16 sm:pb-20 lg:pb-24">
            <h2 class="font-serif text-emerald-900 text-2xl sm:text-3xl">Our Story</h2>
            <div class="relative mt-8">
                <div class="top-0 bottom-0 left-4 md:left-1/2 absolute bg-emerald-200 w-px"></div>
                <ol class="space-y-10">
                    <li class="relative md:gap-12 md:grid md:grid-cols-2">
                        <div class="md:pr-10 md:text-right">
                            <h3 class="font-serif text-emerald-900 text-xl">2015 — Island Beginnings</h3>
                            <p class="mt-2 text-emerald-800/80">On a small tropical island, our founders started blending teas with fruits from the morning market: mango, pineapple, and passionfruit. The first batches were shared with neighbors on warm afternoons.</p>
                        </div>
                        <div class="mt-4 md:mt-0 md:pl-10">
                            <img src="https://i.pinimg.com/736x/fb/62/4d/fb624dcaefc878f56fedd95efa0619df.jpg" alt="Tropical island market" class="shadow-sm rounded-xl ring-1 ring-emerald-100 w-full" />
                        </div>
                    </li>
                    <li class="relative md:gap-12 md:grid md:grid-cols-2">
                        <div class="md:order-2 md:pr-10 md:text-right">
                            <h3 class="font-serif text-emerald-900 text-xl">2018 — First Tea Bar</h3>
                            <p class="mt-2 text-emerald-800/80">We opened a tiny tea bar near the shore, serving cold-brewed tropical blends. Word-of-mouth brought lines of locals and travelers.</p>
                        </div>
                        <div class="md:order-1 mt-4 md:mt-0 md:pl-10">
                            <img src="https://i.pinimg.com/originals/db/8b/e2/db8be20e871de17052918c56683fb91b.jpg" alt="Cozy tea bar" class="shadow-sm rounded-xl ring-1 ring-emerald-100 w-full" />
                        </div>
                    </li>
                    <li class="relative md:gap-12 md:grid md:grid-cols-2">
                        <div class="md:pr-10 md:text-right">
                            <h3 class="font-serif text-emerald-900 text-xl">2021 — Events & Workshops</h3>
                            <p class="mt-2 text-emerald-800/80">We brought PuihahaTea to weddings and community events with pop-up bars and hands-on brewing workshops.</p>
                        </div>
                        <div class="mt-4 md:mt-0 md:pl-10">
                            <img src="https://cdn.shopify.com/s/files/1/2216/2983/files/Art_of_Tea_Blending_Event_Nauteas_Fine_Tea_1.jpg?v=1746628568" alt="Tea workshop" class="shadow-sm rounded-xl ring-1 ring-emerald-100 w-full" />
                        </div>
                    </li>
                    <li class="relative md:gap-12 md:grid md:grid-cols-2">
                        <div class="md:order-2 md:pr-10 md:text-right">
                            <h3 class="font-serif text-emerald-900 text-xl">Today — Shared With You</h3>
                            <p class="mt-2 text-emerald-800/80">We continue to craft small-batch blends using responsibly sourced leaves and sun-kissed fruits — delivering a sip of the tropics wherever you are.</p>
                        </div>
                        <div class="md:order-1 mt-4 md:mt-0 md:pl-10">
                            <img src="https://i.pinimg.com/736x/93/3c/2a/933c2ac5550dd2d4f5cdf03757c803fa.jpg" alt="Tropical tea glass" class="shadow-sm rounded-xl ring-1 ring-emerald-100 w-full" />
                        </div>
                    </li>
                </ol>
            </div>
        </section>

        <!-- Values -->
        <section class="pb-20">
            <h2 class="font-serif text-emerald-900 text-2xl sm:text-3xl">What We Value</h2>
            <div class="gap-6 grid sm:grid-cols-2 lg:grid-cols-3 mt-6">
                <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <h3 class="font-serif text-emerald-900 text-xl">Freshness</h3>
                    <p class="mt-2 text-emerald-800/80">We brew with the freshest harvests and real fruit, never artificial syrups.</p>
                </div>
                <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <h3 class="font-serif text-emerald-900 text-xl">Sustainability</h3>
                    <p class="mt-2 text-emerald-800/80">Our sourcing favors small farms and eco-friendly partners.</p>
                </div>
                <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <h3 class="font-serif text-emerald-900 text-xl">Joy</h3>
                    <p class="mt-2 text-emerald-800/80">Tea is a ritual of joy — our blends are crafted to make moments special.</p>
                </div>
            </div>
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