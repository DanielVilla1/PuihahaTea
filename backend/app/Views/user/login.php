<?php /* Public User Login */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Sign In — PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="flex flex-col min-h-dvh text-gray-800">
    <?= $this->include('components/public_nav') ?>
    <main class="relative flex-1 place-items-center grid px-4" style="min-height:calc(100dvh - 64px);">
        <!-- Tropical background -->
        <div aria-hidden="true" class="-z-10 absolute inset-0">
            <div class="absolute inset-0" style="background-image:url('https://wallpapers-clan.com/wp-content/uploads/2025/03/tropical-beach-sunset-with-pink-sky-desktop-wallpaper-preview.jpg'); background-size:cover; background-position:center;"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-emerald-900/40 via-emerald-800/30 to-amber-700/30"></div>
        </div>
        <div class="w-full max-w-md">
            <div class="drop-shadow text-white text-center">
                <div class="inline-flex items-center gap-2 select-none">
                    <i class="text-2xl fa-solid fa-leaf" aria-hidden="true"></i>
                    <span class="font-serif text-2xl tracking-wide">PuihahaTea</span>
                </div>
                <h1 class="mt-3 font-serif text-3xl">Welcome back</h1>
                <p class="opacity-90 mt-1">Sign in to manage your orders and preferences.</p>
            </div>

            <?php $success = $success ?? null;
            $error = $error ?? null; ?>
            <?php if (!empty($success)): ?>
                <div class="bg-emerald-50/95 mt-6 mb-4 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars((string)$success, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="bg-rose-50/95 mt-6 mb-4 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars((string)$error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form class="bg-white/85 shadow-2xl backdrop-blur mt-6 p-6 rounded-2xl ring-1 ring-emerald-100" method="post" action="/login">
                <div class="space-y-4">
                    <label class="block text-left">
                        <span class="block text-emerald-900/80 text-sm">Email</span>
                        <div class="relative mt-1">
                            <input type="email" name="email" required class="px-3 py-2 border border-emerald-200 focus:border-emerald-400 rounded-md outline-none focus:ring-2 focus:ring-emerald-100 w-full" placeholder="you@example.com" />
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
                </div>
                <button class="bg-emerald-700 hover:bg-emerald-800 mt-6 px-5 py-2.5 rounded-md w-full font-medium text-white">Sign In</button>
                <p class="mt-4 text-emerald-900/80 text-sm text-center">
                    No account yet?
                    <a class="font-medium text-emerald-800 hover:text-emerald-900" href="/register">Create one</a>
                </p>
            </form>
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