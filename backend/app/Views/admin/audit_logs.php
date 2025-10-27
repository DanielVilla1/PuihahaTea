<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1 class="font-serif text-emerald-900 text-3xl">Audit Logs</h1>
<p class="mt-2 text-emerald-900/70">Who did what, and when.</p>

<section class="bg-white shadow-sm mt-6 p-4 sm:p-6 rounded-xl ring-1 ring-emerald-100">
    <div class="mt-2 overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-emerald-900/70 text-left">
                    <th class="py-2 pr-4">Time</th>
                    <th class="py-2 pr-4">Actor</th>
                    <th class="py-2 pr-4">Action</th>
                    <th class="py-2 pr-4">Entity</th>
                    <th class="py-2 pr-4">Details</th>
                </tr>
            </thead>
            <tbody>
                <?php if (! empty($logs)) : ?>
                    <?php foreach ($logs as $log): ?>
                        <tr class="border-t">
                            <td class="py-2 pr-4 text-emerald-900/80"><?= htmlspecialchars($log['created_at'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-2 pr-4">#<?= (int)($log['actor_user_id'] ?? 0) ?></td>
                            <td class="py-2 pr-4"><?= htmlspecialchars($log['action'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-2 pr-4"><?= htmlspecialchars(($log['entity_type'] ?? '') . ' #' . ($log['entity_id'] ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="py-2 pr-4 text-emerald-900/70">
                                <pre class="max-w-[40ch] whitespace-pre-wrap"><?= htmlspecialchars($log['details'] ?? '', ENT_QUOTES, 'UTF-8') ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-6 text-emerald-900/70">No logs yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        <?= isset($pager) ? $pager->links('logs', 'tailwind_full') : '' ?>
    </div>
</section>
<?= $this->endSection() ?>