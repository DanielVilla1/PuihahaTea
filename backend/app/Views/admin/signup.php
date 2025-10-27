<?php /* Admin Signup */ ?>
<!DOCTYPE html>
<html lang="en">
<?php $title = $title ?? 'Employee Sign Up — PuihahaTea'; ?>
<?= $this->include('components/head') ?>

<body class="bg-gradient-to-b from-gray-50 via-emerald-50/20 to-gray-50 min-h-dvh text-gray-800">
    <main class="mx-auto px-4 sm:px-6 lg:px-8 py-12 max-w-md">
        <h1 class="font-serif text-emerald-900 text-3xl">Employee Sign Up</h1>
        <p class="mt-2 text-emerald-900/70">Create an employee account to access the admin dashboard.</p>

        <?php if ($err = session()->getFlashdata('error')): ?>
            <div class="bg-rose-50 mt-4 mb-4 px-4 py-3 border border-rose-200 rounded-md text-rose-900/90"><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <?php /* Signup disabled intentionally. Employees are added by Admin only. */ ?>
    </main>
</body>

</html>