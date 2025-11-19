<?= $this->extend('user/layout') ?>
<?= $this->section('content') ?>
<h1 class="text-2xl font-serif text-emerald-900 mb-4">Your Cart</h1>
<?php if (! empty($success)): ?>
    <div class="bg-emerald-50 border border-emerald-200 rounded-md px-4 py-2 mt-4 text-emerald-800"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (! empty($error)): ?>
    <div class="bg-rose-50 border border-rose-200 rounded-md px-4 py-2 mt-4 text-rose-800"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (! empty($items)): ?>
    <div class="mt-6 grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-4">
            <div class="overflow-hidden rounded-xl ring-1 ring-emerald-100 bg-white">
                <table class="w-full text-sm">
                    <thead class="bg-emerald-50">
                        <tr class="text-left">
                            <th class="py-3 px-4 font-medium text-emerald-900">Product</th>
                            <th class="py-3 px-4 font-medium text-emerald-900">Qty</th>
                            <th class="py-3 px-4 font-medium text-emerald-900">Price</th>
                            <th class="py-3 px-4 font-medium text-emerald-900">Subtotal</th>
                            <th class="py-3 px-4 font-medium text-emerald-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $it): ?>
                        <tr class="border-t border-emerald-100">
                            <td class="py-3 px-4 text-emerald-900/90">#<?= htmlspecialchars($it['product_id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-3 px-4">
                                <form method="post" action="/cart/item/<?= htmlspecialchars($it['id'], ENT_QUOTES, 'UTF-8') ?>/update" class="flex items-center gap-2">
                                    <input type="number" name="quantity" min="1" value="<?= htmlspecialchars($it['quantity'], ENT_QUOTES, 'UTF-8') ?>" class="w-20 border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500" />
                                    <button class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-xs">Update</button>
                                </form>
                            </td>
                            <td class="py-3 px-4">₱<?= htmlspecialchars(number_format((float)$it['unit_price'], 2), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-3 px-4 font-medium">₱<?= htmlspecialchars(number_format(((float)$it['unit_price']) * (int)$it['quantity'], 2), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-3 px-4">
                                <form method="post" action="/cart/item/<?= htmlspecialchars($it['id'], ENT_QUOTES, 'UTF-8') ?>/remove" onsubmit="return confirm('Remove item?')" class="inline">
                                    <button class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white rounded-md text-xs">Remove</button>
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
                <h2 class="font-serif text-lg text-emerald-900 mb-4">Order Summary</h2>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-emerald-900/70">Items</dt><dd class="font-medium text-emerald-900"><?= count($items) ?></dd></div>
                    <div class="flex justify-between"><dt class="text-emerald-900/70">Total</dt><dd class="font-semibold text-emerald-900">₱<?= htmlspecialchars($total, ENT_QUOTES, 'UTF-8') ?></dd></div>
                </dl>
            </div>
            <div class="bg-white p-5 rounded-xl ring-1 ring-emerald-100">
                <h2 class="font-serif text-lg text-emerald-900 mb-4">Checkout</h2>
                <form method="post" action="/cart/checkout" class="space-y-4" id="checkoutForm">
                    <div>
                        <label class="block text-sm font-medium text-emerald-900/80 mb-1">Payment Method</label>
                        <select name="method" id="payMethod" class="w-full border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500" required>
                            <option value="credit">Credit Card</option>
                            <option value="debit">Debit Card</option>
                            <option value="ebank">E-Bank Transfer</option>
                        </select>
                    </div>
                    <div id="methodFields" class="space-y-3"></div>
                    <button class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2.5 rounded-md text-white w-full font-medium">Place Order</button>
                </form>
            </div>
        </div>
    </div>
<?php else: ?>
    <p class="mt-6 text-emerald-900/70">Your cart is empty.</p>
<?php endif; ?>

<?= $this->section('scripts') ?>
<script>
    (function(){
        const methodSel = document.getElementById('payMethod');
        const fieldsWrap = document.getElementById('methodFields');
        function render(){
            if(!methodSel || !fieldsWrap) return;
            const m = methodSel.value;
            let html='';
            if(m==='credit' || m==='debit'){
                html = `
                <div>
                    <label class="block text-sm font-medium text-emerald-900/80 mb-1">Card Holder Name</label>
                    <input type="text" name="card_holder" class="w-full border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-emerald-900/80 mb-1">Card Last 4 Digits</label>
                    <input type="text" name="card_last4" pattern="[0-9]{4}" maxlength="4" class="w-32 border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500" required>
                    <p class="text-[11px] mt-1 text-emerald-700/70">Simulation only – do not enter real card details.</p>
                </div>`;
            } else if(m==='ebank') {
                html = `
                <div>
                    <label class="block text-sm font-medium text-emerald-900/80 mb-1">Bank Name</label>
                    <input type="text" name="bank_name" class="w-full border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-emerald-900/80 mb-1">Transaction Reference</label>
                    <input type="text" name="bank_ref" class="w-full border-emerald-200 focus:border-emerald-500 rounded-md focus:ring-emerald-500" required>
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