<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php if (! empty($success)) : ?>
    <div class="bg-emerald-50 mb-6 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)) : ?>
    <div class="bg-rose-50 mb-6 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h1 class="font-serif text-emerald-900 text-3xl">Edit Employee</h1>
<p class="mt-2 text-emerald-900/70">Update employee details. Role is limited to Staff or Manager.</p>

<form method="post" action="/admin/users/<?= (int)($user['id'] ?? 0) ?>" class="space-y-4 bg-white shadow-sm mt-6 p-6 rounded-xl ring-1 ring-emerald-100 max-w-xl">
    <div>
        <label class="block text-emerald-900/80 text-sm">Full Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" required />
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" required />
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Cellphone</label>
        <input type="text" name="cellphone" value="<?= htmlspecialchars($user['cellphone'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., 09171234567" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Employee Type</label>
        <?php $t = $user['employee_type'] ?? 'staff'; ?>
        <select name="employee_type" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
            <option value="staff" <?= $t === 'staff' ? 'selected' : '' ?>>Staff</option>
            <option value="manager" <?= $t === 'manager' ? 'selected' : '' ?>>Manager</option>
        </select>
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Status</label>
        <?php $s = $user['status'] ?? 'active'; ?>
        <select name="status" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
            <option value="active" <?= $s === 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= $s === 'inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <div class="flex gap-3 pt-2">
        <button class="px-5 py-2 rounded-md btn-sage-dark">Save Changes</button>
        <a href="/admin" class="px-5 py-2 btn-border rounded-md">Cancel</a>
    </div>
</form>

<?= $this->endSection() ?>