<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php if (! empty($success)) : ?>
    <div class="bg-emerald-50 mb-6 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)) : ?>
    <div class="bg-rose-50 mb-6 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h1 class="font-serif text-emerald-900 text-3xl">My Profile</h1>
<p class="mt-2 text-emerald-900/70">Review your account details.</p>

<section class="bg-white shadow-sm mt-6 p-6 rounded-xl ring-1 ring-emerald-100">
    <div class="gap-4 grid sm:grid-cols-2">
        <div>
            <div class="text-emerald-900/70 text-sm">Full Name</div>
            <div class="mt-1 font-medium text-emerald-900"><?= htmlspecialchars($user['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <div>
            <div class="text-emerald-900/70 text-sm">Email</div>
            <div class="mt-1 font-medium text-emerald-900"><?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <div>
            <div class="text-emerald-900/70 text-sm">Role</div>
            <div class="inline-block bg-emerald-50 mt-1 px-2 py-0.5 rounded ring-1 ring-emerald-100 text-emerald-900/80 capitalize"><?= htmlspecialchars($user['employee_type'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
        </div>
        <div>
            <div class="text-emerald-900/70 text-sm">Status</div>
            <?php $active = ($user['status'] ?? 'inactive') === 'active'; ?>
            <div class="mt-1 inline-block <?= $active ? 'bg-emerald-50 ring-emerald-100 text-emerald-900/80' : 'bg-amber-50 ring-amber-100 text-amber-900/80' ?> px-2 py-0.5 rounded ring-1">
                <?= htmlspecialchars($user['status'] ?? 'inactive', ENT_QUOTES, 'UTF-8') ?>
            </div>
        </div>
    </div>
</section>

<h2 class="mt-10 font-serif text-emerald-900 text-2xl">Change Password</h2>
<p class="mt-1 text-emerald-900/70">Update your password below.</p>
<section class="bg-white shadow-sm mt-4 p-6 rounded-xl ring-1 ring-emerald-100 max-w-xl">
    <form method="post" action="/admin/profile/password" class="space-y-4">
        <div>
            <label class="block text-emerald-900/80 text-sm">Current password</label>
            <input name="old_password" type="password" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" required>
        </div>
        <div>
            <label class="block text-emerald-900/80 text-sm">New password</label>
            <input name="new_password" type="password" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" minlength="8" required>
        </div>
        <div>
            <label class="block text-emerald-900/80 text-sm">Confirm new password</label>
            <input name="confirm_password" type="password" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" minlength="8" required>
        </div>
        <div class="pt-2">
            <button class="px-5 py-2 rounded-md btn-sage" type="submit">Update Password</button>
        </div>
    </form>
    <p class="mt-2 text-emerald-900/60 text-sm">Password must be at least 8 characters.</p>

</section>

<?= $this->endSection() ?>