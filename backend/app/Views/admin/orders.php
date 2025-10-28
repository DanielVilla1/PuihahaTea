<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<h1 class="font-serif text-emerald-900 text-3xl">Orders</h1>
<?php if (! empty($success)) : ?>
    <div class="bg-emerald-50 mt-3 mb-4 px-4 py-2 border border-emerald-200 rounded text-emerald-900/90"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)) : ?>
    <div class="bg-rose-50 mt-3 mb-4 px-4 py-2 border border-rose-200 rounded text-rose-900/90"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<p class="mt-2 text-emerald-900/70">Track and update order fulfillment status.</p>

<section class="bg-white shadow-sm mt-6 p-6 rounded-xl ring-1 ring-emerald-100">
    <h2 class="font-semibold text-emerald-900 text-lg">Create quick order</h2>
    <form action="/admin/orders" method="post" class="gap-3 grid md:grid-cols-4 mt-3">
        <input type="text" name="customer_name" placeholder="Customer name" class="px-3 py-2 border rounded" />
        <input type="text" name="items" placeholder='Items (e.g., "2x Milk Tea, 1x Taro")' class="md:col-span-2 px-3 py-2 border rounded" />
        <input type="number" step="0.01" name="total" placeholder="Total (optional)" class="px-3 py-2 border rounded" />
        <div class="md:col-span-4">
            <button class="bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded text-white">Add Order</button>
        </div>
    </form>
</section>

<section class="bg-white shadow-sm mt-6 p-0 rounded-xl ring-1 ring-emerald-100 overflow-hidden">
    <div class="p-6">
        <h2 class="font-semibold text-emerald-900 text-lg">Orders list</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-emerald-50 text-emerald-900">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Customer</th>
                    <th class="px-4 py-2 text-left">Items</th>
                    <th class="px-4 py-2 text-left">Total</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Assigned</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-emerald-900/70 text-center">No orders yet.</td>
                    </tr>
                <?php endif; ?>
                <?php foreach (($orders ?? []) as $o): ?>
                    <tr class="border-t">
                        <td class="px-4 py-2 text-emerald-900/90">#<?= esc($o['id']) ?></td>
                        <td class="px-4 py-2 text-emerald-900/90"><?= esc($o['customer_name'] ?? '-') ?></td>
                        <td class="px-4 py-2 max-w-xs text-emerald-900/90 truncate" title="<?= esc($o['items'] ?? '') ?>"><?= esc($o['items'] ?? '') ?></td>
                        <td class="px-4 py-2 text-emerald-900/90"><?= $o['total'] !== null ? '₱' . number_format((float)$o['total'], 2) : '-' ?></td>
                        <td class="px-4 py-2">
                            <?php $st = $o['status'] ?? 'pending'; ?>
                            <?php
                            $badge = 'bg-gray-100 text-gray-800';
                            if ($st === 'brewing') $badge = 'bg-yellow-100 text-yellow-800';
                            elseif ($st === 'ready') $badge = 'bg-blue-100 text-blue-800';
                            elseif ($st === 'delivered') $badge = 'bg-green-100 text-green-800';
                            elseif ($st === 'cancelled') $badge = 'bg-red-100 text-red-800';
                            ?>
                            <span class="px-2 py-1 rounded text-xs font-medium <?= $badge ?>"><?= esc(ucfirst($st)) ?></span>
                        </td>
                        <td class="px-4 py-2 text-emerald-900/90"><?= esc($o['assigned_to'] ?? '-') ?></td>
                        <td class="px-4 py-2">
                            <div class="flex flex-wrap gap-2">
                                <?php $st = $o['status'] ?? 'pending'; ?>
                                <?php if ($is_admin || $is_manager): ?>
                                    <!-- Managers/Admin: can set main statuses -->
                                    <?php foreach (['pending', 'brewing', 'ready', 'delivered'] as $s): ?>
                                        <?php if ($s !== $st): ?>
                                            <form action="/admin/orders/<?= esc($o['id']) ?>/status" method="post">
                                                <input type="hidden" name="status" value="<?= esc($s) ?>" />
                                                <button class="hover:bg-emerald-50 px-2 py-1 border rounded text-xs" title="Set to <?= esc($s) ?>"><?= esc(ucfirst($s)) ?></button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php if ($st !== 'cancelled' && $st !== 'delivered'): ?>
                                        <form action="/admin/orders/<?= esc($o['id']) ?>/status" method="post">
                                            <input type="hidden" name="status" value="cancelled" />
                                            <button class="bg-rose-600 hover:bg-rose-700 px-2 py-1 rounded text-white text-xs" title="Cancel order">Cancel</button>
                                        </form>
                                    <?php endif; ?>
                                    <form action="/admin/orders/<?= esc($o['id']) ?>/delete" method="post" onsubmit="return confirm('Delete this order? This cannot be undone.')">
                                        <button class="hover:bg-rose-50 px-2 py-1 border border-rose-200 rounded text-rose-700 text-xs" title="Delete order">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <!-- Staff: restricted progression -->
                                    <?php if ($st === 'pending'): ?>
                                        <form action="/admin/orders/<?= esc($o['id']) ?>/status" method="post">
                                            <input type="hidden" name="status" value="brewing" />
                                            <button class="hover:bg-emerald-50 px-2 py-1 border rounded text-xs">Start Brewing</button>
                                        </form>
                                    <?php elseif ($st === 'brewing'): ?>
                                        <form action="/admin/orders/<?= esc($o['id']) ?>/status" method="post">
                                            <input type="hidden" name="status" value="ready" />
                                            <button class="hover:bg-emerald-50 px-2 py-1 border rounded text-xs">Mark Ready</button>
                                        </form>
                                    <?php elseif ($st === 'ready'): ?>
                                        <form action="/admin/orders/<?= esc($o['id']) ?>/status" method="post">
                                            <input type="hidden" name="status" value="delivered" />
                                            <button class="hover:bg-emerald-50 px-2 py-1 border rounded text-xs">Deliver</button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if (! empty($pager)) : ?>
        <div class="p-4">
            <?= $pager->links('orders', 'tailwind_full') ?>
        </div>
    <?php endif; ?>
</section>

<?= $this->endSection() ?>