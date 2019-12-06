<nav aria-label="Page navigation">
    <ul class="pagination my-3">

        <li class="page-item">
            <a class="page-link rounded-0" href="<?=$paginator->getFirstPagePath()?>">&laquo;</a>
        </li>

        <?php foreach ($paginator->getPagesPath() as $path): ?>
            <li class="page-item <?=$path['page'] == $paginator->getCurrentPage() ? 'active' : ''?>">
                <a class="page-link rounded-0" href="<?=$path['path']?>"><?=$path['page']?></a>
            </li>
        <?php endforeach; ?>

        <li class="page-item">
            <a class="page-link rounded-0" href="<?=$paginator->getLastPagePath()?>">&raquo;</a>
        </li>

    </ul>
</nav>