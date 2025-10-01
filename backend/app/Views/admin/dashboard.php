<?php /* Admin Dashboard: manage products for Services gallery */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Admin Dashboard — PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="bg-gradient-to-b from-gray-50 via-emerald-50/20 to-gray-50 min-h-dvh text-gray-800">
    <header class="top-0 z-30 sticky bg-white/80 shadow-sm backdrop-blur">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="font-serif text-emerald-700 text-2xl">🍃 PuihahaTea</a>
                <nav class="hidden md:flex items-center gap-6 text-sm">
                    <a href="/" class="text-emerald-700 hover:text-emerald-900">Site</a>
                    <a href="/services" class="text-emerald-700 hover:text-emerald-900">Services</a>
                    <a href="/admin" class="font-semibold text-emerald-900">Dashboard</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="mx-auto px-4 sm:px-6 lg:px-8 py-10 max-w-6xl">
        <?php if (! empty($success)) : ?>
            <div class="bg-emerald-50 mb-6 px-4 py-3 border border-emerald-200 rounded-md text-emerald-900/90"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
        <?php if (! empty($error)) : ?>
            <div class="bg-rose-50 mb-6 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <section class="mb-12">
            <h1 class="font-serif text-emerald-900 text-3xl">Products</h1>
            <p class="mt-2 text-emerald-900/70">These items power the Services page gallery.</p>
        </section>

        <!-- Create -->
        <section class="bg-white shadow-sm mb-10 p-6 rounded-xl ring-1 ring-emerald-100">
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
                                    <div>
                                        <label class="block font-medium text-emerald-900/80 text-sm">Description</label>
                                        <textarea name="desc" rows="3" class="mt-1 border-emerald-200 focus:border-emerald-400 rounded-md focus:ring-emerald-400 w-full"><?= htmlspecialchars($p['desc'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                                    </div>
                                    <div class="flex justify-between items-center gap-3">
                                        <button type="submit" class="bg-emerald-700 hover:bg-emerald-800 px-4 py-2 rounded-md text-white">Save</button>
                                    </div>
                                </form>
                                <form method="post" action="/admin/products/<?= htmlspecialchars($p['id'], ENT_QUOTES, 'UTF-8') ?>/delete">
                                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 px-4 py-2 rounded-md text-white" onclick="return confirm('Delete this product?')">Delete</button>
                                </form>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="mt-4 text-emerald-900/70">No products yet. Create the first one above.</p>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>