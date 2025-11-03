<?php /* Public: Account settings */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Account Settings — PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="flex flex-col bg-gradient-to-b from-emerald-50 via-lime-50 to-amber-50 min-h-dvh text-gray-800">
    <!-- Nav -->
    <?= $this->include('components/public_nav') ?>

    <main class="flex-1 mx-auto px-4 sm:px-6 lg:px-8 w-full max-w-4xl">
        <section class="py-12 sm:py-16 lg:py-20">
            <h1 class="font-serif text-emerald-900 text-3xl sm:text-4xl">Account settings</h1>
            <?php if (! empty($error)) : ?>
                <div class="bg-rose-50 mt-4 p-3 rounded-md ring-1 ring-rose-200 text-rose-800"><?= esc($error) ?></div>
            <?php endif; ?>
            <?php if (! empty($success)) : ?>
                <div class="bg-emerald-50 mt-4 p-3 rounded-md ring-1 ring-emerald-200 text-emerald-800"><?= esc($success) ?></div>
            <?php endif; ?>

            <?php $c = $customer ?? []; ?>
            <div class="bg-white shadow-sm mt-8 p-6 rounded-2xl ring-1 ring-emerald-100">
                <form class="gap-6 grid sm:grid-cols-2" method="post" action="/account">
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Full Name</label>
                        <input name="name" type="text" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" value="<?= esc($c['name'] ?? '') ?>" required />
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Email</label>
                        <input type="email" class="bg-gray-50 mt-2 border-emerald-200 rounded-md ring-1 ring-emerald-100 w-full" value="<?= esc($c['email'] ?? '') ?>" disabled />
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block font-medium text-emerald-900/80 text-sm">Address</label>
                        <textarea name="address" rows="3" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="House/Unit, Street, Barangay, City, Province"><?= esc($c['address'] ?? '') ?></textarea>
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Cellphone</label>
                        <input name="cellphone" type="tel" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" value="<?= esc($c['cellphone'] ?? '') ?>" />
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 px-6 py-3 rounded-md text-white">Save changes</button>
                        <a href="/" class="ml-3 text-emerald-800 hover:text-emerald-900">Cancel</a>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white shadow-sm mt-8 p-6 rounded-2xl ring-1 ring-emerald-100">
                <h2 class="font-serif text-emerald-900 text-xl">Change password</h2>
                <form class="gap-6 grid sm:grid-cols-2 mt-4" method="post" action="/account/password">
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Current Password</label>
                        <input name="old_password" type="password" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" required />
                    </div>
                    <div class="sm:col-span-1"></div>
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">New Password</label>
                        <input name="new_password" type="password" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" minlength="8" required />
                    </div>
                    <div class="sm:col-span-1">
                        <label class="block font-medium text-emerald-900/80 text-sm">Confirm New Password</label>
                        <input name="confirm_password" type="password" class="mt-2 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" minlength="8" required />
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 px-6 py-3 rounded-md text-white">Update password</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <footer class="bg-white/70 mt-auto border-emerald-100 border-t">
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