<?php
include VIEW_HEADER_ADMIN;

?>

<div class="container">
    <div class="row justify-content-center my-3">
        <h1><?=$title?></h1>
    </div>

    <div class="row pt-3 ml-0 align-items-start">
        <?php include VIEW_TEMPLATE . '/items_per_page_selector.php' ?>
    </div>

    <div class="row py-3 border-bottom ml-0">
        <div class="col-1"><b>id</b></div>
        <div class="col-2"><b>id статьи</b></div>
        <div class="col-5"><b>Содержание</b></div>
        <div class="col-3"><b>Статус</b></div>
        <div class="col-1"></div>
    </div>

    <?php foreach ($items as $item): ?>
        <div class="row py-3 border-bottom ml-0 align-items-start">

            <div class="col-1"><b><?=$item['id']?></b></div>
            <div class="col-2">
                <b><?=$item['article_id']?> </b>
                <a class="btn btn-outline-primary rounded-0 btn-sm ml-2"
                   href="<?=PATH_ARTICLES?>/<?=$item['article_id']?>?preview">Просмотр</a>
            </div>
            <div class="col-5"><?=$item['text']?></div>
            <div class="col-3">
                <form method="post">
                    <text class ="<?=$item['active'] ? '' : 'text-danger font-weight-bold'?>">
                        <?=$item['active'] ? 'Опубликован' : 'На модерации'?>
                    </text>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_active" value="<?=$item['active'] ? 'false' : 'true'?>">
                    <input type="submit" class="btn btn-outline-primary rounded-0 btn-sm  ml-1"
                           name="<?=PATH_COMMENTS?>/<?=$item['id']?>" value="Сменить">
                </form>
            </div>

            <div class="btn-group ml-auto">

                <button  class="btn btn-outline-danger rounded-0 btn-sm" data-toggle="modal" data-target="#deleteModal<?=$item['id']?>">Удалить</button>
                <!-- Modal-->
                <div class="modal fade" id="deleteModal<?=$item['id']?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel">Удаление комментария</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Вы точно уверены? Удаление коннетария необратимо!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Отмена</button>
                                <form method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" class="btn btn-danger rounded-0 ml-3" name="<?=PATH_COMMENTS?>/<?=$item['id']?>" value="Удалить">
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
        include VIEW_TEMPLATE . '/paginator.php';
    endif; ?>


</div>

<?php

include VIEW_FOOTER_ADMIN;

?>
