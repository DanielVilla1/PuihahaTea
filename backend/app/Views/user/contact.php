<?php /* View: Contact page with form-based design */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Contact — PuihahaTea'; ?>
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
                    <a href="/about" class="py-2 text-emerald-700 hover:text-emerald-900">About</a>
                    <a href="/contact" class="py-2 font-semibold text-emerald-900">Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <!-- Page title -->
        <section class="py-12 sm:py-16 lg:py-20">
            <h1 class="font-serif text-emerald-900 text-4xl sm:text-5xl">Contact Us</h1>
            <p class="mt-3 max-w-2xl text-emerald-800/80">We’ll get back within 1–2 business days. Tell us about your event, idea, or any question you have.</p>
        </section>

        <!-- Form -->
        <section class="pb-16 sm:pb-20 lg:pb-24">
            <div class="bg-white shadow-sm p-6 sm:p-8 rounded-2xl ring-1 ring-emerald-100">
                <form class="gap-6 grid sm:grid-cols-2" method="post" action="#">
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Full Name</label>
                        <input type="text" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="Your name" required />
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Email</label>
                        <input type="email" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="you@example.com" required />
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Phone (optional)</label>
                        <input type="tel" class="mt-2 border border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="(+63) 900 000 0000" />
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Subject</label>
                        <input type="text" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="e.g., Tea Bar Catering" required />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block font-medium text-emerald-900/80 text-sm">Message</label>
                        <textarea rows="6" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="Tell us more..." required></textarea>
                    </div>
                    <div class="flex justify-between items-center sm:col-span-2">
                        <label class="inline-flex items-center gap-2 text-emerald-900/80 text-sm">
                            <input type="checkbox" class="border-emerald-300 rounded focus:ring-emerald-500 text-emerald-600" required />
                            I agree to the terms and privacy policy
                        </label>
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 px-6 py-3 rounded-md text-white">Send Message</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- FAQs (optional helper for users) -->
        <section class="pb-20">
            <h2 class="font-serif text-emerald-900 text-2xl">FAQs</h2>
            <dl class="gap-6 grid sm:grid-cols-2 mt-6">
                <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <dt class="font-serif text-emerald-900 text-lg">How soon can you cater an event?</dt>
                    <dd class="mt-2 text-emerald-800/80">We recommend booking 2–4 weeks in advance. Rush requests are possible depending on schedule.</dd>
                </div>
                <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
                    <dt class="font-serif text-emerald-900 text-lg">Do you ship bottled teas?</dt>
                    <dd class="mt-2 text-emerald-800/80">We currently serve fresh at events and select partners; shipping is in the works.</dd>
                </div>
            </dl>
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