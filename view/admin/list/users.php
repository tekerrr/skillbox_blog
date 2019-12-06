<?php

include VIEW_LAYOUT_DIR . 'admin_header.php';

?>

<div class="container pt-4">
    <div class="row justify-content-center my-3">
        <h1><?=$title?></h1>
    </div>

    <div class="row pt-3 ml-0 align-items-start">
        <?php include VIEW_TEMPLATE . 'items_per_page_selector.php' ?>
    </div>

    <div class="row py-3 border-bottom ml-0">
        <div class="col-1"><b>id</b></div>
        <div class="col-3"><b>ФИО</b></div>
        <div class="col-3"><b>Роли</b></div>
        <div class="col-3"><b>Статус</b></div>
        <div class="col-2"></div>
    </div>

    <?php foreach ($items as $item): ?>
        <div class="row py-3 border-bottom ml-0 align-items-start">

            <div class="col-1"><b><?=$item['id']?></b></div>
            <div class="col-3"><?=$item['name']?></div>
            <div class="col-3"><?=implode(', ', $item['groups'])?></div>
            <div class="col-3">
                <form method="post">
                    <text class ="<?=$item['active'] ? '' : 'text-danger font-weight-bold'?>">
                        <?=$item['active'] ? 'Активен' : 'Не активен'?>
                    </text>
                    <input type="hidden" name="type" value="<?=$itemType?>">
                    <input type="hidden" name="id" value="<?=$item['id']?>">
                    <input type="submit" class="btn btn-outline-primary rounded-0 btn-sm  ml-1"
                           name="<?=$item['active'] ? 'submit_unpublish' : 'submit_publish' ?>" value="Сменить">
                </form>
            </div>

            <div class="btn-group ml-auto">

                <a class="btn btn-outline-primary rounded-0 btn-sm"
                   href="?<?=PATH_ADMIN_EDIT . '/' . $itemType?>/<?=$item['id']?>">Изменить</a>

                <button  class="btn btn-outline-danger rounded-0 btn-sm" data-toggle="modal" data-target="#deleteModal<?=$item['id']?>">Удалить</button>
                <!-- Modal-->
                <div class="modal fade" id="deleteModal<?=$item['id']?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Удаление статьи</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Вы точно уверены? Удаление статьи необратимо!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Отмена</button>
                                <form method="post">
                                    <input type="hidden" name="type" value="<?=$itemType?>">
                                    <input type="hidden" name="id" value="<?=$item['id']?>">
                                    <input type="submit" class="btn btn-danger rounded-0 ml-3" name="submit_delete" value="Удалить">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    <?php endforeach; ?>

    <!--Paginator-->
    <?php if ($paginator->isNeeded()):
        include VIEW_TEMPLATE . 'paginator.php';
    endif; ?>


</div>

<?php

include VIEW_LAYOUT_DIR . 'admin_footer.php';

?>