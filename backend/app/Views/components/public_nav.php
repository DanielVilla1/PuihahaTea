<?php
// Public site header navigation with conditional account menu
use function session;
use function esc;
use Config\Services;

$uri = Services::request()->getUri();
$path = trim($uri->getPath(), '/');
$is = function (string $p) use ($path) {
    return $path === trim($p, '/');
};

$cid = (int) (session()->get('customer_id') ?? 0); // real authenticated customer id (0 if not logged in)
// Guest cart id separate from auth id
$cartCid = $cid;
if ($cartCid <= 0) {
    $guestId = (int) (session()->get('guest_customer_id') ?? 0);
    if ($guestId <= 0) {
        $guestId = random_int(1000000000, 1999999999);
        session()->set('guest_customer_id', $guestId);
        // Do NOT set customer_status or customer_id; keep user unauthenticated
    }
    $cartCid = $guestId;
}
$cname = (string) (session()->get('customer_name') ?? '');
$cemail = (string) (session()->get('customer_email') ?? '');
$cstatus = strtolower(trim((string) (session()->get('customer_status') ?? 'regular')));
$display = $cname !== '' ? $cname : ($cemail !== '' ? $cemail : 'Account');

// Map status to a pill style
$statusLabel = $cstatus !== '' ? ucfirst($cstatus) : 'Regular';
if ($cstatus === 'vip') {
    $statusLabel = 'VIP';
}
$statusClass = 'bg-gray-100 text-gray-700 border border-gray-200';
if ($cstatus === 'vip') {
    $statusClass = 'bg-amber-100 text-amber-800 border border-amber-300';
} elseif ($cstatus === 'guest') {
    $statusClass = 'bg-sky-100 text-sky-800 border border-sky-300';
} elseif ($cstatus === 'regular') {
    $statusClass = 'bg-gray-100 text-gray-700 border border-gray-200';
}

?>
<header class="top-0 z-30 sticky bg-white/80 supports-[backdrop-filter]:bg-white/60 shadow-sm backdrop-blur">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="flex justify-between items-center h-16">
            <a href="/" class="flex items-center gap-2 font-serif text-emerald-700 text-2xl">
                <span>🍃</span>
                <span class="tracking-wide">PuihahaTea</span>
            </a>
            <nav class="hidden md:flex items-center gap-8 text-base">
                <a href="/" class="py-2 <?= $is('') ? 'font-semibold text-emerald-900' : 'text-emerald-700 hover:text-emerald-900' ?>">Home</a>
                <a href="/services" class="py-2 <?= $is('services') ? 'font-semibold text-emerald-900' : 'text-emerald-700 hover:text-emerald-900' ?>">Services</a>
                <a href="/about" class="py-2 <?= $is('about') ? 'font-semibold text-emerald-900' : 'text-emerald-700 hover:text-emerald-900' ?>">About</a>
                <a href="/contact" class="py-2 <?= $is('contact') ? 'font-semibold text-emerald-900' : 'text-emerald-700 hover:text-emerald-900' ?>">Contact</a>
                <?php
                $cartCount = 0;
                try {
                    $cartService = \Config\Services::cartService();
                    $items = $cartService->listItems($cartCid);
                    $cartCount = is_array($items) ? count($items) : 0;
                } catch (\Throwable $e) {
                    $cartCount = 0;
                }
                ?>
                <a href="/cart" class="inline-flex relative items-center py-2 text-emerald-700 hover:text-emerald-900" title="View Cart">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1" />
                        <circle cx="20" cy="21" r="1" />
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                    </svg>
                    <?php if ($cartCount > 0): ?>
                        <span class="-top-1 -right-2 absolute bg-rose-600 px-1.5 py-0.5 rounded-full min-w-[1.25rem] font-semibold text-white text-xs text-center" aria-label="Cart items"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
                <?php if ($cid > 0): ?>
                    <div class="relative" x-data="{ open: false }">
                        <button id="accountBtn" class="inline-flex items-center gap-2 hover:bg-emerald-50 px-3 py-2 rounded-md ring-1 ring-emerald-200 text-emerald-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5Zm0 2c-4.418 0-8 2.239-8 5v1h16v-1c0-2.761-3.582-5-8-5Z" />
                            </svg>
                            <span class="max-w-[14ch] truncate" title="<?= esc($display) ?>"><?= esc($display) ?></span>
                            <?php if ($cid > 0): ?>
                                <span class="text-[11px] px-2 py-0.5 rounded-full <?= $statusClass ?>" title="Status: <?= esc($statusLabel) ?>"><?= esc($statusLabel) ?></span>
                            <?php endif; ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M7 10l5 5 5-5z" />
                            </svg>
                        </button>
                        <div id="accountMenu" class="hidden right-0 absolute bg-white shadow-lg mt-2 rounded-md ring-1 ring-emerald-100 w-44 overflow-hidden">
                            <a href="/account" class="block hover:bg-emerald-50 px-4 py-2 text-emerald-800">Account settings</a>
                            <a href="/logout" class="block hover:bg-emerald-50 px-4 py-2 text-emerald-800">Sign out</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="hover:bg-emerald-50 px-3 py-2 rounded-md ring-1 ring-emerald-200 text-emerald-800">Sign In</a>
                <?php endif; ?>
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
            <a href="/" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700 <?= $is('') ? 'font-semibold' : '' ?>">Home</a>
            <a href="/services" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700 <?= $is('services') ? 'font-semibold' : '' ?>">Services</a>
            <a href="/about" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700 <?= $is('about') ? 'font-semibold' : '' ?>">About</a>
            <a href="/contact" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700 <?= $is('contact') ? 'font-semibold' : '' ?>">Contact</a>
            <?php
            $mCartCount = 0;
            try {
                $cartService = \Config\Services::cartService();
                $mItems = $cartService->listItems($cartCid);
                $mCartCount = is_array($mItems) ? count($mItems) : 0;
            } catch (\Throwable $e) {
                $mCartCount = 0;
            }
            ?>
            <a href="/cart" class="flex items-center gap-2 hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                </svg>
                <span>Cart<?php if ($mCartCount > 0): ?> (<?= $mCartCount ?>)<?php endif; ?></span>
            </a>
            <?php if ($cid > 0): ?>
                <a href="/account" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700">Account settings</a>
                <a href="/logout" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700">Sign out</a>
            <?php else: ?>
                <a href="/login" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-700">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<script>
    // simple mobile menu and account dropdown toggle
    (function() {
        const btn = document.getElementById('navToggle');
        const menu = document.getElementById('mobileMenu');
        if (btn && menu) {
            btn.addEventListener('click', () => {
                const open = menu.classList.contains('hidden');
                menu.classList.toggle('hidden');
                btn.setAttribute('aria-expanded', String(open));
            });
        }
        const ab = document.getElementById('accountBtn');
        const am = document.getElementById('accountMenu');
        if (ab && am) {
            ab.addEventListener('click', (e) => {
                e.preventDefault();
                am.classList.toggle('hidden');
            });
            document.addEventListener('click', (e) => {
                if (!am.classList.contains('hidden')) {
                    const t = e.target;
                    if (t !== ab && !ab.contains(t) && t !== am && !am.contains(t)) {
                        am.classList.add('hidden');
                    }
                }
            });
        }
    })();
</script>