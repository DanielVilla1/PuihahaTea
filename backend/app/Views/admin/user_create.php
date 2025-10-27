<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php if (! empty($success)) : ?>
    <div class="bg-emerald-50 mb-6 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)) : ?>
    <div class="bg-rose-50 mb-6 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h1 class="font-serif text-emerald-900 text-3xl">Add Employee</h1>
<p class="mt-2 text-emerald-900/70">Create a new employee account.</p>

<form method="post" action="/admin/users" class="space-y-4 bg-white shadow-sm mt-6 p-6 rounded-xl ring-1 ring-emerald-100 max-w-xl">
    <div>
        <label class="block text-emerald-900/80 text-sm">Full Name</label>
        <input type="text" name="name" required class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Email</label>
        <input type="email" name="email" required class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Temporary Password</label>
        <input type="password" name="password" required class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
        <p class="mt-1 text-emerald-900/70 text-xs">Share this password with the employee; they can change it later.</p>
    </div>
    <div class="gap-4 grid grid-cols-1 sm:grid-cols-2">
        <div>
            <label class="block text-emerald-900/80 text-sm">Employee Type</label>
            <select name="employee_type" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
                <option value="staff">Staff</option>
                <option value="manager">Manager</option>
            </select>
        </div>
        <div>
            <label class="block text-emerald-900/80 text-sm">Status</label>
            <select name="status" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
                <option value="active" selected>Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
    <div class="flex gap-3">
        <a href="/admin" class="px-4 py-2 btn-border rounded-md">Cancel</a>
        <button class="px-5 py-2 rounded-md btn-sage-dark">Create</button>
    </div>
</form>

<?= $this->endSection() ?>