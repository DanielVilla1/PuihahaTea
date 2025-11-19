<?= $this->extend('user/layout') ?>
<?= $this->section('content') ?>
<h1 class="mb-4 font-serif text-emerald-900 text-2xl">Your Cart</h1>
<?php if (! empty($success)): ?>
    <div class="bg-emerald-50 mt-4 px-4 py-2 border border-emerald-200 rounded-md text-emerald-800"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)): ?>
    <div class="bg-rose-50 mt-4 px-4 py-2 border border-rose-200 rounded-md text-rose-800"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (! empty($items)): ?>
    <div class="gap-8 grid lg:grid-cols-3 mt-6">
        <div class="space-y-4 lg:col-span-2">
            <div class="bg-white rounded-xl ring-1 ring-emerald-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-emerald-50">
                        <tr class="text-left">
                            <th class="px-4 py-3 font-medium text-emerald-900">Product</th>
                            <th class="px-4 py-3 font-medium text-emerald-900">Qty</th>
                            <th class="px-4 py-3 font-medium text-emerald-900">Price</th>
                            <th class="px-4 py-3 font-medium text-emerald-900">Subtotal</th>
                            <th class="px-4 py-3 font-medium text-emerald-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $it): ?>
                            <tr class="border-emerald-100 border-t">
                                <td class="px-4 py-3 text-emerald-900/90">#<?= htmlspecialchars($it['product_id'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-4 py-3">
                                    <form method="post" action="/cart/item/<?= htmlspecialchars($it['id'], ENT_QUOTES, 'UTF-8') ?>/update" class="flex items-center gap-2">
                                        <input type="number" name="quantity" min="1" value="<?= htmlspecialchars($it['quantity'], ENT_QUOTES, 'UTF-8') ?>" class="border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500 w-20" />
                                        <button class="bg-emerald-600 hover:bg-emerald-700 px-3 py-1.5 rounded-md text-white text-xs">Update</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3">₱<?= htmlspecialchars(number_format((float)$it['unit_price'], 2), ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-4 py-3 font-medium">₱<?= htmlspecialchars(number_format(((float)$it['unit_price']) * (int)$it['quantity'], 2), ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="px-4 py-3">
                                    <form method="post" action="/cart/item/<?= htmlspecialchars($it['id'], ENT_QUOTES, 'UTF-8') ?>/remove" onsubmit="return confirm('Remove item?')" class="inline">
                                        <button class="bg-rose-600 hover:bg-rose-700 px-3 py-1.5 rounded-md text-white text-xs">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-white p-5 rounded-xl ring-1 ring-emerald-100">
                <h2 class="mb-4 font-serif text-emerald-900 text-lg">Order Summary</h2>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-emerald-900/70">Items</dt>
                        <dd class="font-medium text-emerald-900"><?= count($items) ?></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-emerald-900/70">Total</dt>
                        <dd class="font-semibold text-emerald-900">₱<?= htmlspecialchars($total, ENT_QUOTES, 'UTF-8') ?></dd>
                    </div>
                </dl>
            </div>
            <div class="bg-white p-5 rounded-xl ring-1 ring-emerald-100">
                <h2 class="mb-4 font-serif text-emerald-900 text-lg">Checkout</h2>
                <form method="post" action="/cart/checkout" class="space-y-4" id="checkoutForm">
                    <div>
                        <label class="block mb-1 font-medium text-emerald-900/80 text-sm">Payment Method</label>
                        <select name="method" id="payMethod" class="border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500 w-full" required>
                            <option value="credit">Credit Card</option>
                            <option value="debit">Debit Card</option>
                            <option value="ebank">E-Bank Transfer</option>
                        </select>
                    </div>
                    <div id="methodFields" class="space-y-3"></div>
                    <button class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2.5 rounded-md w-full font-medium text-white">Place Order</button>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <p class="mt-6 text-emerald-900/70">Your cart is empty.</p>
<?php endif; ?>

<?= $this->section('scripts') ?>
<script>
    (function() {
        const methodSel = document.getElementById('payMethod');
        const fieldsWrap = document.getElementById('methodFields');

        function render() {
            if (!methodSel || !fieldsWrap) return;
            const m = methodSel.value;
            let html = '';
            if (m === 'credit' || m === 'debit') {
                html = `
                <div>
                    <label class="block mb-1 font-medium text-emerald-900/80 text-sm">Card Holder Name</label>
                    <input type="text" name="card_holder" class="border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500 w-full" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-emerald-900/80 text-sm">Card Last 4 Digits</label>
                    <input type="text" name="card_last4" pattern="[0-9]{4}" maxlength="4" class="border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500 w-32" required>
                    <p class="mt-1 text-[11px] text-emerald-700/70">Simulation only – do not enter real card details.</p>
                </div>`;
            } else if (m === 'ebank') {
                html = `
                <div>
                    <label class="block mb-1 font-medium text-emerald-900/80 text-sm">Bank Name</label>
                    <input type="text" name="bank_name" class="border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500 w-full" required>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-emerald-900/80 text-sm">Transaction Reference</label>
                    <input type="text" name="bank_ref" class="border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500 w-full" required>
                </div>`;
            }
            fieldsWrap.innerHTML = html;
        }
        methodSel && methodSel.addEventListener('change', render);
        render();
    })();
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>