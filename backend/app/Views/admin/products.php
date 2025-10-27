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
<h1 class="font-serif text-emerald-900 text-3xl">Products</h1>
<p class="mt-2 text-emerald-900/70">Tea inventory used on Services page.</p>

<!-- Create -->
<section class="bg-white shadow-sm mt-6 mb-10 p-6 rounded-xl ring-1 ring-emerald-100">
    <h2 class="font-serif text-emerald-900 text-xl">Add Product</h2>
    <form class="gap-4 grid sm:grid-cols-2 mt-4" method="post" action="/admin/products">
        <div>
            <label class="block font-medium text-emerald-900/80 text-sm">Title</label>
            <input name="title" required maxlength="255" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
        </div>
        <div>
            <label class="block font-medium text-emerald-900/80 text-sm">Image URL</label>
            <input name="img" maxlength="2048" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
        </div>
        <div>
            <label class="block font-medium text-emerald-900/80 text-sm">Price (₱)</label>
            <input name="price" type="number" min="0" step="0.01" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
        </div>
        <div>
            <label class="block font-medium text-emerald-900/80 text-sm">Stock</label>
            <input name="stock" type="number" min="0" step="1" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
        </div>
        <div class="sm:col-span-2">
            <label class="block font-medium text-emerald-900/80 text-sm">Description</label>
            <textarea name="desc" rows="3" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full"></textarea>
        </div>
        <div class="sm:col-span-2">
            <button class="bg-emerald-700 hover:bg-emerald-800 px-5 py-2 rounded-md text-white">Create</button>
        </div>
    </form>
</section>

<!-- List/Edit/Delete -->
<section class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
    <h2 class="font-serif text-emerald-900 text-xl">Existing Products</h2>
    <?php if (! empty($products)) : ?>
        <div class="gap-6 grid sm:grid-cols-2 lg:grid-cols-3 mt-4">
            <?php foreach ($products as $p): ?>
                <article class="rounded-xl ring-1 ring-emerald-100 overflow-hidden">
                    <div class="relative bg-emerald-50 aspect-[4/3] overflow-hidden">
                        <img src="<?= htmlspecialchars($p['img'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($p['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover" />
                    </div>
                    <div class="space-y-3 p-4">
                        <form method="post" action="/admin/products/<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>" class="space-y-3">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>" />
                            <div>
                                <label class="block font-medium text-emerald-900/80 text-sm">Title</label>
                                <input name="title" value="<?= htmlspecialchars($p['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>" maxlength="255" required class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
                            </div>
                            <div>
                                <label class="block font-medium text-emerald-900/80 text-sm">Image URL</label>
                                <input name="img" value="<?= htmlspecialchars($p['img'] ?? '', ENT_QUOTES, 'UTF-8') ?>" maxlength="2048" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
                            </div>
                            <div class="gap-3 grid grid-cols-2">
                                <div>
                                    <label class="block font-medium text-emerald-900/80 text-sm">Price (₱)</label>
                                    <input name="price" type="number" min="0" step="0.01" value="<?= htmlspecialchars($p['price'] ?? '0.00', ENT_QUOTES, 'UTF-8') ?>" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
                                </div>
                                <div>
                                    <label class="block font-medium text-emerald-900/80 text-sm">Stock</label>
                                    <input name="stock" type="number" min="0" step="1" value="<?= htmlspecialchars($p['stock'] ?? '0', ENT_QUOTES, 'UTF-8') ?>" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
                                </div>
                            </div>
                            <div>
                                <label class="block font-medium text-emerald-900/80 text-sm">Description</label>
                                <textarea name="desc" rows="3" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full"><?= htmlspecialchars($p['desc'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                            </div>
                            <div class="flex justify-between items-center gap-3">
                                <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white">Save</button>
                            </div>
                        </form>
                        <?php if ($isAdmin || $isManager): ?>
                            <form method="post" action="/admin/products/<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>/delete">
                                <button type="submit" class="bg-rose-600 hover:bg-rose-700 px-4 py-2 rounded-md text-white" onclick="return confirm('Delete this product?')">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="mt-4 text-emerald-900/70">No products yet. Create the first one above.</p>
    <?php endif; ?>
</section>
<?= $this->endSection() ?>