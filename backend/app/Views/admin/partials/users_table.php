<div class="mt-4 overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead>
            <tr class="text-emerald-900/70 text-left">
                <th class="py-2 pr-4">Name</th>
                <th class="py-2 pr-4">Email</th>
                <th class="py-2 pr-4">Cellphone</th>
                <th class="py-2 pr-4">Type</th>
                <th class="py-2 pr-4">Status</th>
                <th class="py-2 pr-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($users)) : ?>
                <?php foreach ($users as $u): ?>
                    <tr class="border-t">
                        <td class="py-2 pr-4 align-top">
                            <?= htmlspecialchars($u['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td class="py-2 pr-4 align-top">
                            <?= htmlspecialchars($u['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td class="py-2 pr-4 align-top">
                            <?= htmlspecialchars($u['cellphone'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </td>
                        <td class="py-2 pr-4 align-top">
                            <span class="inline-block bg-emerald-50 px-2 py-0.5 rounded ring-1 ring-emerald-100 text-emerald-900/80">
                                <?= htmlspecialchars($u['employee_type'] ?? 'staff', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td class="py-2 pr-4 align-top">
                            <span class="inline-block px-2 py-0.5 rounded <?= ($u['status'] ?? 'active') === 'active' ? 'bg-emerald-50 ring-emerald-100 text-emerald-900/80' : 'bg-amber-50 ring-amber-100 text-amber-900/80' ?> ring-1">
                                <?= htmlspecialchars($u['status'] ?? 'active', ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </td>
                        <td class="py-2 pr-4">
                            <?php if (!empty($is_admin)) : ?>
                                <div class="flex gap-2">
                                    <a class="px-3 py-1 rounded btn-sage-dark" href="/admin/users/<?= htmlspecialchars($u['id'], ENT_QUOTES, 'UTF-8') ?>/edit">Edit</a>
                                    <form method="post" action="/admin/users/<?= htmlspecialchars($u['id'], ENT_QUOTES, 'UTF-8') ?>/delete" onsubmit="return confirm('Delete this user?')">
                                        <button class="bg-rose-600 hover:bg-rose-700 px-3 py-1 rounded text-white">Delete</button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="text-emerald-900/50">View only</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="py-6 text-emerald-900/70">No accounts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4" id="usersPager">
    <?= isset($pager) ? $pager->links('users', 'tailwind_full') : '' ?>

</div>