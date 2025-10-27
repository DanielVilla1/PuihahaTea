<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<h1 class="font-serif text-emerald-900 text-3xl">Analytics</h1>
<p class="mt-2 text-emerald-900/70">Sales, stock, feedback, revenue trends (coming soon).</p>
<section class="gap-4 grid md:grid-cols-2 mt-6">
    <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
        <h2 class="font-medium text-emerald-900">Sales</h2>
        <div class="bg-emerald-50 mt-3 rounded h-40"></div>
    </div>
    <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
        <h2 class="font-medium text-emerald-900">Stocks</h2>
        <div class="bg-emerald-50 mt-3 rounded h-40"></div>
    </div>
    <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
        <h2 class="font-medium text-emerald-900">Feedback</h2>
        <div class="bg-emerald-50 mt-3 rounded h-40"></div>
    </div>
    <div class="bg-white shadow-sm p-6 rounded-xl ring-1 ring-emerald-100">
        <h2 class="font-medium text-emerald-900">Revenue Trends</h2>
        <div class="bg-emerald-50 mt-3 rounded h-40"></div>
    </div>
</section>
<?= $this->endSection() ?>