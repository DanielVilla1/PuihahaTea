<?php /* Public Email Verification (code input) */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Verify Email — PuihahaTea'; ?>
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
                <h1 class="mt-3 font-serif text-3xl">Verify your email</h1>
                <p class="opacity-90 mt-1">Enter the verification code we sent to your email to activate your account.</p>
            </div>

            <?php $success = $success ?? null;
            $error = $error ?? null; ?>
            <?php if (!empty($success)): ?>
                <div class="bg-emerald-50/95 mt-6 mb-4 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars((string)$success, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div class="bg-rose-50/95 mt-6 mb-4 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars((string)$error, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>

            <form class="bg-white/85 shadow-2xl backdrop-blur mt-6 p-6 rounded-2xl ring-1 ring-emerald-100" method="post" action="/verify">
                <div class="space-y-4">
                    <label class="block text-left">
                        <span class="block text-emerald-900/80 text-sm">Verification code</span>
                        <div class="relative mt-1">
                            <input type="text" name="code" required inputmode="numeric" autocomplete="one-time-code" pattern="\d{6}" maxlength="6" class="px-3 py-2 border border-emerald-200 focus:border-emerald-400 rounded-md outline-none focus:ring-2 focus:ring-emerald-100 w-full" placeholder="Enter 6-digit code" />
                        </div>
                    </label>
                </div>
                <button class="bg-emerald-700 hover:bg-emerald-800 mt-6 px-5 py-2.5 rounded-md w-full font-medium text-white">Verify</button>
                <p class="mt-4 text-emerald-50 text-sm text-center">
                    Already verified?
                    <a class="font-medium text-white/90 hover:text-white underline" href="/login">Sign in</a>
                </p>
            </form>
        </div>
    </main>
</body>

</html>