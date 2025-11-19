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
<p class="mt-2 text-emerald-900/70">Product inventory used on Services page.</p>

<!-- Filters/Search -->
<section class="bg-white shadow-sm mt-4 p-4 rounded-xl ring-1 ring-emerald-100">
    <form method="get" class="items-end gap-3 grid sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label class="block font-medium text-emerald-900/80 text-sm">Search Title/Description</label>
            <input type="text" name="q" value="<?= htmlspecialchars($filters['q'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g. Matcha, Espresso, Tuna" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
        </div>
        <div>
            <label class="block font-medium text-emerald-900/80 text-sm">Category</label>
            <select name="type" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
                <?php $t = strtolower($filters['type'] ?? ''); ?>
                <option value="" <?= $t === '' ? 'selected' : '' ?>>All</option>
                <option value="tea" <?= $t === 'tea' ? 'selected' : '' ?>>Teas</option>
                <option value="coffee" <?= $t === 'coffee' ? 'selected' : '' ?>>Coffee's</option>
                <option value="sandwich" <?= $t === 'sandwich' ? 'selected' : '' ?>>Sandwich</option>
            </select>
        </div>
        <div>
            <label class="block font-medium text-emerald-900/80 text-sm">Per Page</label>
            <?php $per = (int) ($filters['per'] ?? 10); ?>
            <select name="per" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
                <?php foreach ([10, 20, 50, 100] as $n): ?>
                    <option value="<?= $n ?>" <?= $per === $n ? 'selected' : '' ?>><?= $n ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex gap-2">
            <button class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white">Apply</button>
            <a href="/admin/products" class="bg-white hover:bg-emerald-50 px-4 py-2 rounded-md ring-1 ring-emerald-200 text-emerald-900">Reset</a>
        </div>
    </form>
    <div class="mt-2 text-emerald-900/60 text-xs">Tip: Use Category = Coffee's or Sandwich to focus non-tea products.</div>
    <?php /* Top pager removed per request */ ?>
</section>

<!-- Create (restricted to Admin/Manager) -->
<?php // Add form moved into an "Add Product" card below for consistent UX with Edit 
?>

<!-- List/Edit/Delete -->
<section class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
    <h2 class="font-serif text-emerald-900 text-xl">Existing Products</h2>
    <?php if (! empty($products)) : ?>
        <div class="gap-6 grid sm:grid-cols-2 lg:grid-cols-3 mt-4">
            <?php if ($isAdmin || $isManager): ?>
                <!-- Add Product Card -->
                <article class="rounded-xl ring-1 ring-emerald-100 overflow-hidden">
                    <div class="relative flex justify-center items-center bg-emerald-50 aspect-[4/3]">
                        <div class="bg-white/80 shadow-sm p-4 rounded-lg ring-1 ring-emerald-200 text-center">
                            <div class="font-serif text-emerald-900 text-lg">Add Product</div>
                            <div class="mt-1 text-emerald-900/70 text-sm">Create a new item</div>
                            <button type="button" data-toggle="edit-form" data-target="edit-form-new" aria-controls="edit-form-new" aria-expanded="false" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 mt-3 px-4 py-1.5 rounded-md text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v5.5h5.5a.75.75 0 010 1.5h-5.5v5.5a.75.75 0 01-1.5 0v-5.5h-5.5a.75.75 0 010-1.5h5.5v-5.5A.75.75 0 0110 3z" clip-rule="evenodd" />
                                </svg>
                                Add
                            </button>
                        </div>
                    </div>
                    <div class="hidden p-4" id="edit-form-new">
                        <form method="post" action="/admin/products" class="space-y-3">
                            <div>
                                <label class="block font-medium text-emerald-900/80 text-sm">Title</label>
                                <input name="title" required maxlength="255" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
                            </div>
                            <div>
                                <label class="block font-medium text-emerald-900/80 text-sm">Image URL</label>
                                <input name="img" maxlength="2048" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
                            </div>
                            <div>
                                <label class="block font-medium text-emerald-900/80 text-sm">Category (hidden from users)</label>
                                <select name="category" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
                                    <option value="">None</option>
                                    <option value="tea">Tea</option>
                                    <option value="coffee">Coffee</option>
                                    <option value="sandwich">Sandwich</option>
                                </select>
                            </div>
                            <div class="gap-3 grid grid-cols-2">
                                <div>
                                    <label class="block font-medium text-emerald-900/80 text-sm">Price (₱)</label>
                                    <input name="price" type="number" min="0" step="0.01" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
                                </div>
                                <div>
                                    <label class="block font-medium text-emerald-900/80 text-sm">Stock</label>
                                    <input name="stock" type="number" min="0" step="1" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full" />
                                </div>
                            </div>
                            <div>
                                <label class="block font-medium text-emerald-900/80 text-sm">Description</label>
                                <textarea name="desc" rows="3" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full"></textarea>
                            </div>
                            <div class="flex justify-between items-center gap-3">
                                <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white">Add Product</button>
                                <button type="button" data-toggle="edit-form" data-target="edit-form-new" class="bg-white hover:bg-emerald-50 px-4 py-2 rounded-md ring-1 ring-emerald-200 text-emerald-900">Cancel</button>
                            </div>
                        </form>
                    </div>
                </article>
            <?php endif; ?>
            <?php foreach ($products as $p): ?>
                <article class="rounded-xl ring-1 ring-emerald-100 overflow-hidden">
                    <div class="relative bg-emerald-50 aspect-[4/3] overflow-hidden">
                        <img src="<?= htmlspecialchars($p['img'] ?? '', ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($p['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>" class="w-full h-full object-cover" />
                    </div>
                    <div class="space-y-3 p-4">
                        <div class="space-y-2" id="view-block-<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>">
                            <div class="flex justify-between items-start gap-3">
                                <div class="font-semibold text-emerald-900 text-lg"><?= htmlspecialchars($p['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                                <?php if ($isAdmin || $isManager): ?>
                                    <div class="flex gap-2">
                                        <button type="button" data-toggle="edit-form" data-target="edit-form-<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>" class="bg-emerald-700 hover:bg-emerald-800 px-3 py-1.5 rounded-md text-white">Edit</button>
                                        <form method="post" action="/admin/products/<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>/delete">
                                            <button type="submit" class="bg-rose-600 hover:bg-rose-700 px-3 py-1.5 rounded-md text-white" onclick="return confirm('Delete this product?')">Delete</button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="text-emerald-900/80 text-sm break-all">URL: <?= htmlspecialchars($p['img'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="gap-3 grid grid-cols-2 text-sm">
                                <div>
                                    <div class="font-medium text-emerald-900/80">Price (₱)</div>
                                    <div class="mt-0.5 text-emerald-900"><?= htmlspecialchars($p['price'] ?? '0.00', ENT_QUOTES, 'UTF-8') ?></div>
                                </div>
                                <div>
                                    <div class="font-medium text-emerald-900/80">Stock</div>
                                    <div class="mt-0.5 text-emerald-900"><?= htmlspecialchars($p['stock'] ?? '0', ENT_QUOTES, 'UTF-8') ?></div>
                                </div>
                            </div>
                            <div>
                                <div class="font-medium text-emerald-900/80 text-sm">Description</div>
                                <div class="mt-0.5 text-emerald-900/80 text-sm whitespace-pre-line"><?= htmlspecialchars($p['desc'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                        </div>

                        <?php if ($isAdmin || $isManager): ?>
                            <!-- Edit form hidden by default -->
                            <div id="edit-form-<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>" class="hidden">
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
                                    <div>
                                        <label class="block font-medium text-emerald-900/80 text-sm">Category (hidden from users)</label>
                                        <?php $cat = strtolower($p['category'] ?? ''); ?>
                                        <select name="category" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full">
                                            <option value="" <?= $cat === '' ? 'selected' : '' ?>>None</option>
                                            <option value="tea" <?= $cat === 'tea' ? 'selected' : '' ?>>Tea</option>
                                            <option value="coffee" <?= $cat === 'coffee' ? 'selected' : '' ?>>Coffee</option>
                                            <option value="sandwich" <?= $cat === 'sandwich' ? 'selected' : '' ?>>Sandwich</option>
                                        </select>
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
                                        <textarea name="desc" rows="3" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full"><?php echo htmlspecialchars($p['desc'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                    </div>
                                    <div class="flex justify-between items-center gap-3">
                                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white">Save Changes</button>
                                        <button type="button" data-toggle="edit-form" data-target="edit-form-<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>" class="bg-white hover:bg-emerald-50 px-4 py-2 rounded-md ring-1 ring-emerald-200 text-emerald-900">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="mt-4 text-emerald-900/70">No products yet. Create the first one above.</p>
    <?php endif; ?>
    <?php if (! empty($products) && isset($pager)) : ?>
        <div class="mt-6">
            <?= $pager->links('products', 'tailwind_full') ?>
        </div>
    <?php endif; ?>
</section>
<?php if ($isAdmin || $isManager): ?>
    <script>
        (function() {
            function toggle(id) {
                var el = document.getElementById(id);
                if (!el) return;
                if (el.classList.contains('hidden')) {
                    el.classList.remove('hidden');
                } else {
                    el.classList.add('hidden');
                }
            }
            document.addEventListener('click', function(e) {
                var btn = e.target.closest('[data-toggle="edit-form"]');
                if (!btn) return;
                var target = btn.getAttribute('data-target');
                if (target) toggle(target);
            });
        })();
    </script>
<?php endif; ?>
<?= $this->endSection() ?>