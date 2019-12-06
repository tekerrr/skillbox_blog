<?php

include VIEW_HEADER_ADMIN;

?>

<div class="container">
    <div class="row justify-content-center my-3">
        <h1><?=$title?></h1>
    </div>

    <div class="row pt-3 ml-0 align-items-start">
        <a class="btn btn-outline-primary rounded-0" href="<?=PATH_ARTICLES . '/create'?>">Создать</a>

        <?php include VIEW_TEMPLATE . '/items_per_page_selector.php' ?>
    </div>

    <div class="row py-3 border-bottom ml-0">
        <div class="col-1"><b>id</b></div>
        <div class="col-5"><b>Название</b></div>
        <div class="col-3"><b>Статус</b></div>
        <div class="col-3"></div>
    </div>

    <?php foreach ($items as $item): ?>
        <div class="row py-3 border-bottom ml-0 align-items-start">

            <div class="col-1"><b><?=$item['id']?></b></div>
            <div class="col-5"><?=$item['title']?></div>
            <div class="col-3 btn-group">
                <text class ="mr-2 <?=$item['active'] ? '' : 'text-danger font-weight-bold'?>">
                    <?=$item['active'] ? 'Активна' : 'Не активна'?>
                </text>

                <?php if ($item['active']): ?>
                    <form method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_active" value="false">
                        <input type="submit" class="btn btn-outline-primary rounded-0 btn-sm" name="<?=PATH_ARTICLES?>/<?=$item['id']?>" value="Сменить">
                    </form>
                <?php else: ?>
                    <button  class="btn btn-outline-danger rounded-0 btn-sm col-4" data-toggle="modal" data-target="#activateModal<?=$item['id']?>">Сменить</button>
                    <!-- Modal-->
                    <div class="modal fade" id="activateModal<?=$item['id']?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Публикация статьи</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Опубликовать с рассылкой сообщений?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Отмена</button>
                                    <form method="post">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_active" value="true">
                                        <input type="submit" class="btn btn-primary rounded-0 ml-3"
                                               name="<?=PATH_ARTICLES?>/<?=$item['id']?>" value="Без рассылки">
                                    </form>
                                    <form method="post">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_active" value="true">
                                        <input type="hidden" name="notify" value="true">
                                        <input type="submit" class="btn btn-primary rounded-0 ml-3" name="<?=PATH_ARTICLES?>/<?=$item['id']?>" value="С рассылкой">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="btn-group ml-auto">

                <a class="btn btn-outline-primary rounded-0 btn-sm"
                   href="<?=PATH_ARTICLES?>/<?=$item['id']?>?preview">Просмотр</a>
                <a class="btn btn-outline-primary rounded-0 btn-sm"
                   href="<?=PATH_ARTICLES . '/' . $item['id'] . '/edit'?>">Изменить</a>

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
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" class="btn btn-danger rounded-0 ml-3" name="<?=PATH_ARTICLES?>/<?=$item['id']?>" value="Удалить">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    <?php endforeach; ?>

    <div class="row my-3 ml-0">
        <a class="btn btn-outline-primary rounded-0" href="<?=PATH_ARTICLES . '/create'?>">Создать</a>
    </div>

    <!--Paginator-->
    <?php if ($paginator->isNeeded()):
        include VIEW_TEMPLATE . '/paginator.php';
    endif; ?>


</div>

<?php

include VIEW_FOOTER_ADMIN;

?>
