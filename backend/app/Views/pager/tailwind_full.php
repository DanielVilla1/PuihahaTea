<?php

/**
 * Tailwind-ish pager template for CI4
 * Expected data vars: $pager, $group, $template
 */

$pager->setSurroundCount(2);

?>
<nav aria-label="Pagination" class="mt-2">
    <ul class="inline-flex items-center gap-1">
        <?php if ($pager->hasPreviousPage()) : ?>
            <li>
                <a class="hover:bg-emerald-50 px-3 py-1 border border-emerald-200 rounded text-emerald-800" href="<?= $pager->getFirst() ?>" aria-label="First">« First</a>
            </li>
            <li>
                <a class="hover:bg-emerald-50 px-3 py-1 border border-emerald-200 rounded text-emerald-800" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">‹ Prev</a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li>
                <?php if ($link['active']) : ?>
                    <span class="bg-emerald-600 px-3 py-1 border border-emerald-600 rounded text-white" aria-current="page"><?= $link['title'] ?></span>
                <?php else : ?>
                    <a class="hover:bg-emerald-50 px-3 py-1 border border-emerald-200 rounded text-emerald-800" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
                <?php endif ?>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNextPage()) : ?>
            <li>
                <a class="hover:bg-emerald-50 px-3 py-1 border border-emerald-200 rounded text-emerald-800" href="<?= $pager->getNextPage() ?>" aria-label="Next">Next ›</a>
            </li>
            <li>
                <a class="hover:bg-emerald-50 px-3 py-1 border border-emerald-200 rounded text-emerald-800" href="<?= $pager->getLast() ?>" aria-label="Last">Last »</a>
            </li>
        <?php endif ?>
    </ul>
</nav>