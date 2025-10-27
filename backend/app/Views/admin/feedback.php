<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>
<h1 class="font-serif text-emerald-900 text-3xl">Customer Feedback</h1>
<p class="mt-2 text-emerald-900/70">Read customer feedback and reviews. (Read-only)</p>
<section class="bg-white shadow-sm mt-6 p-6 rounded-xl ring-1 ring-emerald-100">
    <p class="text-emerald-900/70">No feedback data yet. This page will list reviews when available.</p>
</section>
<?= $this->endSection() ?>