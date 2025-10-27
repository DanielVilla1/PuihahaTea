<?php /* Admin Login */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Admin Login — PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="bg-gradient-to-b from-emerald-50 via-lime-50 to-amber-50 min-h-dvh text-gray-800">
    <main class="place-items-center grid px-4 min-h-dvh">
        <div class="w-full max-w-md">
            <div class="flex flex-col items-center text-center">
                <div class="inline-flex items-center gap-2 text-emerald-800 select-none">
                    <span class="text-3xl" aria-hidden="true">🍃</span>
                    <span class="font-serif text-2xl tracking-wide">PuihahaTea</span>
                </div>
                <h1 class="mt-4 font-serif text-emerald-900 text-3xl">Employee Login</h1>
                <p class="mt-2 text-emerald-900/70">Only employees can access the admin dashboard.</p>
            </div>

            <?php if ($msg = session()->getFlashdata('success')): ?>
                <div class="bg-emerald-50 mt-6 mb-4 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <?php if ($err = session()->getFlashdata('error')): ?>
                <div class="bg-rose-50 mt-6 mb-4 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form class="bg-white shadow-xl mt-6 p-6 rounded-2xl ring-1 ring-emerald-100" method="post" action="/admin/login">
                <div class="space-y-4">
                    <label class="block text-left">
                        <span class="block text-emerald-900/80 text-sm">Email</span>
                        <div class="relative mt-1">
                            <input type="email" name="email" required class="px-3 py-2 border border-emerald-200 focus:border-emerald-400 rounded-md outline-none focus:ring-2 focus:ring-emerald-100 w-full" placeholder="you@company.com" />
                        </div>
                    </label>

                    <label class="block text-left">
                        <span class="block text-emerald-900/80 text-sm">Password</span>
                        <div class="relative mt-1">
                            <input id="password" type="password" name="password" required class="py-2 pr-12 pl-3 border border-emerald-200 focus:border-emerald-400 rounded-md outline-none focus:ring-2 focus:ring-emerald-100 w-full" placeholder="••••••••" />
                            <button type="button" id="togglePw" class="inline-flex top-1/2 right-2 absolute justify-center items-center w-8 h-8 text-emerald-700/70 hover:text-emerald-900 -translate-y-1/2" aria-label="Show password" title="Show password">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 4.5c-4.86 0-9 3.06-10.5 7.5 1.5 4.44 5.64 7.5 10.5 7.5s9-3.06 10.5-7.5C21 7.56 16.86 4.5 12 4.5Zm0 12a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z" />
                                </svg>
                            </button>
                        </div>
                    </label>

                    <!-- optional helper row retained for future links -->
                </div>
                <button class="bg-emerald-700 hover:bg-emerald-800 mt-6 px-5 py-2.5 rounded-md w-full font-medium text-white">Login</button>
            </form>

            <p class="mt-6 text-emerald-900/60 text-sm text-center">Having trouble? Contact your administrator.</p>
        </div>
    </main>

    <script>
        (function() {
            const pw = document.getElementById('password');
            const btn = document.getElementById('togglePw');
            const icon = document.getElementById('eyeIcon');
            if (!pw || !btn) return;
            btn.addEventListener('click', () => {
                const showing = pw.type === 'text';
                pw.type = showing ? 'password' : 'text';
                btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
                btn.title = showing ? 'Show password' : 'Hide password';
                if (icon) {
                    icon.innerHTML = showing ?
                        '<path d="M12 4.5c-4.86 0-9 3.06-10.5 7.5 1.5 4.44 5.64 7.5 10.5 7.5s9-3.06 10.5-7.5C21 7.56 16.86 4.5 12 4.5Zm0 12a4.5 4.5 0 1 1 0-9 4.5 4.5 0 0 1 0 9Z"/>' :
                        '<path d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l2.04 2.04C2.63 7.03 1.5 8.64 1.5 12c1.5 4.44 5.64 7.5 10.5 7.5 2.17 0 4.22-.62 5.96-1.7l2.5 2.5a.75.75 0 1 0 1.06-1.06L3.53 2.47ZM12 6a6 6 0 0 1 6 6c0 .63-.11 1.23-.31 1.79l-2.13-2.13A3.75 3.75 0 0 0 12 8.25c-.42 0-.81.07-1.18.2L8.75 6.38C9.76 6.12 10.86 6 12 6Zm-1.5 6a1.5 1.5 0 0 1 2.06-1.4l2.84 2.84A3 3 0 0 1 10.5 12Z"/>';
                }
            });
        })();
    </script>
</body>

</html>