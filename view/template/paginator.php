<?php
$addGet = isset($paginatorItemsPerPage) ? '&items=' . $paginatorItemsPerPage : '';
?>

<nav aria-label="Page navigation">
    <ul class="pagination">

        <li class="page-item">
            <a class="page-link rounded-0" href="?<?=$paginator->getPath()?>/1<?=$addGet?>">&laquo;</a>
        </li>

        <?php foreach ($paginator->getPages() as $page): ?>
            <li class="page-item <?=$page == $paginator->getCurrentPage() ? 'active' : ''?>">
                <a class="page-link rounded-0" href="?<?=$paginator->getPath()?>/<?=$page . $addGet?>"><?=$page?></a>
            </li>
        <?php endforeach; ?>

        <li class="page-item">
            <a class="page-link rounded-0" href="?<?=$paginator->getPath()?>/<?=$paginator->getLastPage() . $addGet?>">&raquo;</a>
        </li>

    </ul>
</nav>