<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php if (! empty($success)) : ?>
    <div class="bg-emerald-50 mb-6 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)) : ?>
    <div class="bg-rose-50 mb-6 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h1 class="font-serif text-emerald-900 text-3xl">Dashboard</h1>
<p class="mt-2 text-emerald-900/70">Overview and controls.</p>

<!-- Summary cards (for Admin and Employees) -->
<section class="gap-4 grid sm:grid-cols-2 lg:grid-cols-3 mt-6">
    <div class="bg-white shadow-sm p-5 rounded-xl ring-1 ring-emerald-100">
        <div class="text-emerald-900/70 text-sm">Daily Sales</div>
        <div class="mt-1 font-semibold text-emerald-900 text-2xl">₱<?= number_format($dailySales ?? 0, 2) ?></div>
    </div>
    <div class="bg-white shadow-sm p-5 rounded-xl ring-1 ring-emerald-100">
        <div class="text-emerald-900/70 text-sm">Pending Orders</div>
        <div class="mt-1 font-semibold text-emerald-900 text-2xl"><?= (int)($pendingOrders ?? 0) ?></div>
    </div>
    <div class="bg-white shadow-sm p-5 rounded-xl ring-1 ring-emerald-100">
        <div class="text-emerald-900/70 text-sm">Stock Alerts</div>
        <div class="mt-1 font-semibold text-emerald-900 text-2xl"><?= (int)($stockAlerts ?? 0) ?></div>
    </div>
</section>

<?php
$session = \Config\Services::session();
$role = $session->get('employee_type') ?? '';
$isManager = ($role === 'manager');
?>
<?php if (!empty($is_admin) || $isManager) : ?>
    <!-- Filters -->
    <form method="get" id="userFiltersForm" class="flex flex-wrap items-end gap-3 mt-6">
        <div class="min-w-56 grow">
            <label class="block text-emerald-900/80 text-sm">Search</label>
            <input type="search" name="q" value="<?= htmlspecialchars($filters['q'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Search by name or email" class="mt-1 border border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
        </div>
        <div>
            <label class="block text-emerald-900/80 text-sm">Status</label>
            <select name="status" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400">
                <option value="">All</option>
                <?php $selStatus = $filters['status'] ?? ''; ?>
                <option value="active" <?= $selStatus === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $selStatus === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
        <div>
            <label class="block text-emerald-900/80 text-sm">Employee Type</label>
            <select name="type" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400">
                <option value="">All</option>
                <?php $selType = $filters['type'] ?? ''; ?>
                <option value="staff" <?= $selType === 'staff' ? 'selected' : '' ?>>Staff</option>
                <option value="manager" <?= $selType === 'manager' ? 'selected' : '' ?>>Manager</option>
            </select>
        </div>
        <div>
            <input type="hidden" name="page_users" value="1" />
            <div class="flex gap-2">
                <button class="px-4 py-2 rounded-md btn-sage">Apply</button>
                <button type="button" id="btnClearFilters" class="px-4 py-2 btn-border rounded-md">Clear</button>
            </div>
        </div>
    </form>

    <!-- Users table (Admin only) -->
    <section class="bg-white shadow-sm mt-6 p-4 sm:p-6 rounded-xl ring-1 ring-emerald-100">
        <div class="flex justify-between items-center">
            <h2 class="font-serif text-emerald-900 text-xl">Accounts</h2>
            <?php if (!empty($is_admin)) : ?>
                <a class="px-4 py-2 btn-border rounded-md" href="/admin/users/create">Add Employee</a>
            <?php endif; ?>
        </div>
        <div id="usersTableWrap">
            <?= view('admin/partials/users_table', ['users' => $users, 'pager' => $pager, 'is_admin' => $is_admin]) ?>
        </div>
    </section>
<?php endif; ?>

<script>
    (function() {
        const wrap = document.getElementById('usersTableWrap');
        if (!wrap) return;

        const toAjaxUrl = (href) => {
            try {
                const url = new URL(href, window.location.origin);
                url.searchParams.set('ajax', '1');
                return url.toString();
            } catch (e) {
                const hasQ = href.indexOf('?') !== -1;
                const sep = hasQ ? '&' : '?';
                return href + sep + 'ajax=1';
            }
        };

        const bindPager = () => {
            wrap.querySelectorAll('nav a[href]').forEach(a => {
                a.addEventListener('click', function(ev) {
                    ev.preventDefault();
                    const href = this.getAttribute('href');
                    if (!href) return;
                    const ajaxUrl = toAjaxUrl(href);
                    fetch(ajaxUrl, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(r => r.text())
                        .then(html => {
                            wrap.innerHTML = html;
                            try {
                                const clean = new URL(ajaxUrl);
                                clean.searchParams.delete('ajax');
                                window.history.pushState({}, '', clean.toString());
                            } catch (e) {}
                            bindPager();
                        })
                        .catch(() => {});
                }, {
                    passive: false
                });
            });
        };

        bindPager();

        // Clear filters button: clears search, status and employee type, resets page to 1, and submits form
        const form = document.getElementById('userFiltersForm');
        const clearBtn = document.getElementById('btnClearFilters');
        if (form && clearBtn) {
            clearBtn.addEventListener('click', function() {
                const q = form.querySelector('input[name="q"]');
                const status = form.querySelector('select[name="status"]');
                const type = form.querySelector('select[name="type"]');
                const page = form.querySelector('input[name="page_users"]');

                if (q) q.value = '';
                if (status) status.selectedIndex = 0;
                if (type) type.selectedIndex = 0;
                if (page) page.value = '1';

                // Ensure action doesn't preserve stale query params
                try {
                    form.setAttribute('action', window.location.pathname);
                } catch (e) {}

                form.submit();
            });
        }
    })();
</script>

<?= $this->endSection() ?>