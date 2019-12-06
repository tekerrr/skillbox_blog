<?php use App\Router; ?>

<?php if (Router::isActivePath(PATH_ADMIN_VIEW . '/article')): ?>
    <div class="row mx-0 justify-content-end">

        <form method="post">
            <input type="hidden" name="type" value="comment">
            <input type="hidden" name="id" value="<?=$comment['id']?>">
            <div class="btn-group ml-auto">
                <?php if ($comment['active']): ?>
                    <input type="submit" class="btn btn-outline-primary rounded-0"
                           name="submit_unpublish" value="Снять с публикации">
                <?php else: ?>
                    <input type="submit" class="btn btn-outline-primary rounded-0"
                           name="submit_publish" value="Опубликовать">
                <?php endif;?>
            </div>
        </form>

        <button  class="btn btn-outline-danger rounded-0 ml-3" data-toggle="modal" data-target="#deleteModal<?=$comment['id']?>">Удалить</button>
        <!-- Modal-->
        <div class="modal fade" id="deleteModal<?=$comment['id']?>" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Удаление статьи</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Вы точно уверены? Удаление коннетария необратимо!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Закрыть</button>
                        <form method="post">
                            <input type="hidden" name="type" value="comment">
                            <input type="hidden" name="id" value="<?=$comment['id']?>">
                            <input type="submit" class="btn btn-danger rounded-0 ml-3" name="submit_delete" value="Удалить">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>