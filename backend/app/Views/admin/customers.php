<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php if (! empty($success)) : ?>
    <div class="bg-emerald-50 mb-6 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)) : ?>
    <div class="bg-rose-50 mb-6 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php $session = \Config\Services::session();
$role = $session->get('employee_type') ?? 'guest';
$isAdmin = $role === 'admin';
$isManager = $role === 'manager'; ?>

<h1 class="font-serif text-emerald-900 text-3xl">Customers</h1>
<p class="mt-2 text-emerald-900/70">Manage customer records. Admin can add/edit/delete; Manager can view only.</p>

<div class="flex justify-between items-center mt-6">
    <div></div>
    <?php if ($isAdmin): ?>
        <a href="/admin/customers/create" class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white">Add Customer</a>
    <?php endif; ?>
</div>

<!-- Filters -->
<form method="get" id="customerFiltersForm" class="flex flex-wrap items-end gap-3 mt-6">
    <div class="min-w-56 grow">
        <label class="block text-emerald-900/80 text-sm">Account No</label>
        <input type="search" name="account" value="<?= htmlspecialchars($filters['account'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., CUST-001" class="mt-1 border border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
    </div>
    <div class="min-w-56 grow">
        <label class="block text-emerald-900/80 text-sm">Name</label>
        <input type="search" name="name" value="<?= htmlspecialchars($filters['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., Maria Santos" class="mt-1 border border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
    </div>
    <div class="min-w-56 grow">
        <label class="block text-emerald-900/80 text-sm">Email</label>
        <input type="search" name="email" value="<?= htmlspecialchars($filters['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., user@example.com" class="mt-1 border border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
    </div>
    <div class="min-w-56 grow">
        <label class="block text-emerald-900/80 text-sm">Cellphone</label>
        <input type="search" name="cellphone" value="<?= htmlspecialchars($filters['cellphone'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g., 09171234567" class="mt-1 border border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Status</label>
        <?php $selStatus = $filters['status'] ?? ''; ?>
        <select name="status" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400">
            <option value="">All</option>
            <option value="regular" <?= $selStatus === 'regular' ? 'selected' : '' ?>>Regular</option>
            <option value="vip" <?= $selStatus === 'vip' ? 'selected' : '' ?>>VIP</option>
            <option value="guest" <?= $selStatus === 'guest' ? 'selected' : '' ?>>Guest</option>
        </select>
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Verification</label>
        <?php $selVerified = $filters['verified'] ?? 'verified'; ?>
        <select name="verified" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400">
            <option value="verified" <?= $selVerified === 'verified' ? 'selected' : '' ?>>Verified</option>
            <option value="pending" <?= $selVerified === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="all" <?= $selVerified === 'all' ? 'selected' : '' ?>>All</option>
        </select>
    </div>
    <div>
        <label class="block text-emerald-900/80 text-sm">Per page</label>
        <?php $selPer = (int)($filters['per'] ?? 10); ?>
        <select name="per" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400">
            <?php foreach ([10, 20, 50, 100] as $opt): ?>
                <option value="<?= $opt ?>" <?= $selPer === $opt ? 'selected' : '' ?>><?= $opt ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <input type="hidden" name="page_customers" value="1" />
        <div class="flex gap-2">
            <button class="px-4 py-2 rounded-md btn-sage">Apply</button>
            <button type="button" id="btnClearCustomerFilters" class="px-4 py-2 btn-border rounded-md">Clear</button>
        </div>
    </div>

</form>

<section class="bg-white shadow-sm mt-4 p-6 rounded-xl ring-1 ring-emerald-100" id="customersSection">
    <div class="overflow-x-auto">
        <table class="min-w-full align-middle">
            <thead>
                <tr class="text-emerald-900/70 text-sm text-left">
                    <th class="px-3 py-2">Account No</th>
                    <th class="px-3 py-2">Name</th>
                    <th class="px-3 py-2">Address</th>
                    <th class="px-3 py-2">Email</th>
                    <th class="px-3 py-2">Cellphone</th>
                    <th class="px-3 py-2">Status</th>
                    <th class="px-3 py-2">Created At</th>
                    <th class="px-3 py-2">Updated At</th>
                    <?php if ($isAdmin): ?><th class="px-3 py-2">Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-100">
                <?php if (! empty($customers)): ?>
                    <?php foreach ($customers as $c): ?>
                        <tr class="text-emerald-900">
                            <td class="px-3 py-2 font-mono text-sm"><?= htmlspecialchars($c['account_number'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-3 py-2"><?= htmlspecialchars($c['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-3 py-2 max-w-[320px] truncate" title="<?= htmlspecialchars($c['address'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($c['address'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-3 py-2"><?= htmlspecialchars($c['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-3 py-2"><?= htmlspecialchars($c['cellphone'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-3 py-2 capitalize"><?= htmlspecialchars($c['status'] ?? 'regular', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-3 py-2 text-emerald-900/80 text-sm"><?= htmlspecialchars($c['created_at'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="px-3 py-2 text-emerald-900/80 text-sm"><?= htmlspecialchars($c['updated_at'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <?php if ($isAdmin): ?>
                                <td class="px-3 py-2">
                                    <div class="flex gap-2">
                                        <a class="hover:bg-emerald-50 px-3 py-1 rounded-md ring-1 ring-emerald-200 text-emerald-800" href="/admin/customers/<?= htmlspecialchars($c['id'], ENT_QUOTES, 'UTF-8') ?>/edit">Edit</a>
                                        <form method="post" action="/admin/customers/<?= htmlspecialchars($c['id'], ENT_QUOTES, 'UTF-8') ?>/delete" onsubmit="return confirm('Delete this customer?');">
                                            <button class="bg-rose-600 hover:bg-rose-700 px-3 py-1 rounded-md text-white" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="px-3 py-6 text-emerald-900/70" colspan="9">No customers found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($pager) && $pager): ?>
        <div class="mt-4">
            <?= $pager->links('customers', 'tailwind_full') ?>
        </div>
    <?php endif; ?>
</section>

<script>
    (function() {
        // Preserve filters on pagination by merging current query with target page
        const section = document.getElementById('customersSection');
        if (!section) return;
        const form = document.getElementById('customerFiltersForm');
        const clearBtn = document.getElementById('btnClearCustomerFilters');

        // Clear filters
        if (form && clearBtn) {
            clearBtn.addEventListener('click', function() {
                ['account', 'name', 'email', 'cellphone'].forEach(n => {
                    const el = form.querySelector(`[name="${n}"]`);
                    if (el) el.value = '';
                });
                const status = form.querySelector('select[name="status"]');
                const per = form.querySelector('select[name="per"]');
                const page = form.querySelector('input[name="page_customers"]');
                if (status) status.selectedIndex = 0;
                if (per) per.value = '10';
                if (page) page.value = '1';
                try {
                    form.setAttribute('action', window.location.pathname);
                } catch (e) {}
                form.submit();
            });
        }

        // Intercept pager links to keep filters
        section.querySelectorAll('nav a[href]').forEach(a => {
            a.addEventListener('click', function(ev) {
                ev.preventDefault();
                const href = this.getAttribute('href');
                if (!href) return;
                try {
                    const current = new URL(window.location.href);
                    const target = new URL(href, window.location.origin);
                    const targetPage = target.searchParams.get('page_customers') || '1';
                    current.searchParams.set('page_customers', targetPage);
                    // Keep relevant filters
                    ['account', 'name', 'email', 'cellphone', 'status', 'verified', 'per'].forEach(key => {
                        const v = (form && form.elements[key]) ? form.elements[key].value : current.searchParams.get(key);
                        if (v) current.searchParams.set(key, v);
                        else current.searchParams.delete(key);
                    });
                    window.location.assign(current.toString());
                } catch (e) {
                    window.location.assign(href);
                }
            }, {
                passive: false
            });
        });
    })();
</script>

<?= $this->endSection() ?>