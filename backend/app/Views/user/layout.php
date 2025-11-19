<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="flex flex-col bg-gradient-to-b from-emerald-50 via-lime-50 to-amber-50 min-h-dvh text-gray-800">
    <?= $this->include('components/public_nav') ?>
    <main class="flex-grow mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full max-w-6xl">
        <?= $this->renderSection('content') ?>
    </main>
    <footer class="bg-white/70 mt-auto border-emerald-100 border-t" role="contentinfo">
        <div class="flex sm:flex-row flex-col justify-between items-center gap-4 mx-auto px-4 sm:px-6 lg:px-8 py-8 max-w-6xl text-emerald-900/70 text-sm">
            <p>© <?= date('Y'); ?> PuihahaTea. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="hover:text-emerald-900">Instagram</a>
                <a href="#" class="hover:text-emerald-900">Facebook</a>
                <a href="#" class="hover:text-emerald-900">X</a>
            </div>
        </div>
    </footer>
    <!-- Optional page-specific scripts -->
    <?= $this->renderSection('scripts') ?>
</body>

</html>