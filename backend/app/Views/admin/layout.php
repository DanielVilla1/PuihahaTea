<?php /* Admin layout with left sidebar navigation */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Admin — PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="bg-gray-50 text-gray-800">
    <div class="flex min-h-dvh">
        <!-- Sidebar -->
        <aside class="hidden sm:flex sm:flex-col bg-white p-4 border-r w-64">
            <a href="/admin" class="mb-4 font-serif text-emerald-800 text-2xl">🍃 Admin</a>
            <?php $session = \Config\Services::session();
            $role = $session->get('employee_type') ?? 'guest';
            $isAdmin = $role === 'admin';
            $userName = $session->get('user_name') ?? 'Unknown';
            $userEmail = $session->get('user_email') ?? ''; ?>

            <!-- Signed-in user -->
            <div class="bg-emerald-50/60 mb-4 p-3 rounded-lg ring-1 ring-emerald-100 text-sm">
                <div class="flex justify-between items-center gap-2">
                    <div class="font-medium text-emerald-900 truncate" title="<?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <span class="bg-white px-2 py-0.5 rounded-full ring-1 ring-emerald-200 text-emerald-900/80 text-xs capitalize"><?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <?php if ($userEmail): ?>
                    <div class="mt-0.5 text-emerald-900/70 truncate" title="<?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($userEmail, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
            </div>

            <nav class="space-y-1">
                <a href="/admin" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-900">Dashboard</a>
                <a href="/admin/products" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-900">Teas</a>
                <a href="/admin/orders" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-900">Orders</a>
                <a href="/admin/analytics" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-900">Analytics</a>
                <a href="/admin/suppliers" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-900">Suppliers</a>
                <a href="/admin/feedback" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-900">Feedback</a>
                <?php if ($isAdmin): ?>
                    <a href="/admin/audit-logs" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-900">Audit Logs</a>
                    <a href="/admin/settings" class="block hover:bg-emerald-50 px-3 py-2 rounded text-emerald-900">Settings</a>
                <?php endif; ?>
                <a href="/admin/logout" class="block hover:bg-rose-50 px-3 py-2 rounded text-rose-900">Logout</a>
            </nav>
        </aside>

        <!-- Main -->
        <main class="flex-1 p-4 sm:p-8">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- Back to Top: improved design with tooltip & transitions -->
    <div id="backToTopWrap" class="group right-6 bottom-6 z-40 fixed opacity-0 transition-opacity duration-300 pointer-events-none">
        <button
            id="backToTopBtn"
            type="button"
            aria-label="Back to top"
            title="Back to top"
            class="relative flex justify-center items-center bg-gradient-to-br from-emerald-600 hover:from-emerald-700 to-teal-600 hover:to-teal-700 shadow-lg hover:shadow-xl rounded-full focus:outline-none ring-1 ring-white/20 focus-visible:ring-2 focus-visible:ring-emerald-400 w-12 h-12 text-white active:scale-[0.98] transition transform">
            <!-- Up arrow icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="drop-shadow w-6 h-6">
                <path fill-rule="evenodd" d="M12 4.5a.75.75 0 0 1 .53.22l6.75 6.75a.75.75 0 1 1-1.06 1.06L12.75 6.56V19.5a.75.75 0 0 1-1.5 0V6.56L5.78 12.53a.75.75 0 0 1-1.06-1.06l6.75-6.75A.75.75 0 0 1 12 4.5Z" clip-rule="evenodd" />
            </svg>
            <!-- Tooltip -->
            <span class="-top-10 right-0 absolute bg-emerald-900 opacity-0 group-hover:opacity-100 shadow px-2 py-1 rounded-md ring-1 ring-emerald-700/50 text-white/90 text-xs whitespace-nowrap transition translate-y-1/2 pointer-events-none">Back to top</span>
        </button>
    </div>

    <script>
        (function() {
            const wrap = document.getElementById('backToTopWrap');
            const btn = document.getElementById('backToTopBtn');
            if (!wrap || !btn) return;

            const toggle = () => {
                const scrollY = window.scrollY || document.documentElement.scrollTop;
                const doc = document.documentElement;
                const nearBottom = (doc.scrollHeight - (scrollY + window.innerHeight)) < 200;
                if (scrollY > 300 || nearBottom) {
                    wrap.classList.remove('opacity-0', 'pointer-events-none');
                } else {
                    wrap.classList.add('opacity-0', 'pointer-events-none');
                }
            };

            window.addEventListener('scroll', toggle, {
                passive: true
            });
            window.addEventListener('resize', toggle);
            document.addEventListener('DOMContentLoaded', toggle);

            btn.addEventListener('click', function() {
                try {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                } catch (e) {
                    window.scrollTo(0, 0);
                }
            });
        })();
    </script>
</body>

</html>