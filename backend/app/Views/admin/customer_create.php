<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php if (! empty($success)) : ?>
    <div class="bg-emerald-50 mb-6 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)) : ?>
    <div class="bg-rose-50 mb-6 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h1 class="font-serif text-emerald-900 text-3xl">Add Customer</h1>
<p class="mt-2 text-emerald-900/70">Create a new customer profile.</p>

<section class="bg-white shadow-sm mt-6 p-6 rounded-xl ring-1 ring-emerald-100">
    <form class="gap-4 grid sm:grid-cols-2" method="post" action="/admin/customers">
        <div class="sm:col-span-1">
            <label class="block font-medium text-emerald-900/80 text-sm">Account Number</label>
            <input name="account_number" required maxlength="32" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="CUST-0001" />
        </div>
        <div class="sm:col-span-1">
            <label class="block font-medium text-emerald-900/80 text-sm">Full Name</label>
            <input name="name" required maxlength="120" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="Juan Dela Cruz" />
        </div>
        <div class="sm:col-span-2">
            <label class="block font-medium text-emerald-900/80 text-sm">Address</label>
            <input name="address" maxlength="255" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="Street, City, Province" />
        </div>
        <div class="sm:col-span-1">
            <label class="block font-medium text-emerald-900/80 text-sm">Email</label>
            <input name="email" type="email" required maxlength="190" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="you@example.com" />
        </div>
        <div class="sm:col-span-1">
            <label class="block font-medium text-emerald-900/80 text-sm">Cellphone</label>
            <input name="cellphone" maxlength="32" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" placeholder="0917 000 0000" />
        </div>
        <div class="sm:col-span-1">
            <label class="block font-medium text-emerald-900/80 text-sm">Status</label>
            <select name="status" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
                <option value="regular">Regular</option>
                <option value="vip">VIP</option>
                <option value="guest">Guest</option>
            </select>
        </div>
        <div class="sm:col-span-2">
            <button class="bg-emerald-700 hover:bg-emerald-800 px-5 py-2 rounded-md text-white">Create</button>
            <a href="/admin/customers" class="hover:bg-emerald-50 ml-2 px-4 py-2 rounded-md ring-1 ring-emerald-200 text-emerald-800">Cancel</a>
        </div>
    </form>
</section>

<?= $this->endSection() ?>