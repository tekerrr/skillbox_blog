<?php

include ($preview ? VIEW_HEADER_ADMIN : VIEW_HEADER);

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="w-75">
            <article>
                <div class="mt-5">
                    <img src="/img/article/<?=$article['image'] ?? 'default_image.png'?>" alt="post img" class="img-fluid">
                </div>
                <h1 class="text-center mt-4"><?=$article['title']?></h1>
                <p class=""><i><?=$article['create_time']?></i></p>
                <?=$article['text']?>
            </article>

            <!--Comments-->
            <h3 class="py-3">Комментарии</h3>

            <?php if ($comments): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="media py-3">
                        <div class="col-1 mr-3">
                            <img src="/img/user/<?=$comment['user']['image'] ?? 'default_avatar.png'?>" alt="post img" class="img-fluid">
                        </div>
                        <div class="media-body py-0">
                            <h4><?=$comment['user']['name']?></h4>
                            <p><i><?=$comment['create_time']?></i></p>
                            <p><?=$comment['text']?></p>

                            <?php includeView(
                                    'template.comment_button_for_admin',
                                    ['id' => $comment['id'], 'active' => $comment['active'], 'preview' => $preview],
                            ); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Отсутствуют... Будьте первым!</p>
            <?php endif; ?>

            <!--Add comment-->
            <div class="border-top py-4">
                <form class="form" action="" method="post">
                    <div class="form-group">
                        <?php includeView('template.input.area_comment', [
                            'name' => ($name = 'comment'),
                            'label' => 'Оставить комментарий',
                            'field' => $fields[$name] ?? [],
                            'rows' => '2',
                        ]); ?>
                    </div>
                    <input type="hidden" name="article_id" value="<?=$article['id']?>">
                    <div class="row mx-0 pt-4">
                        <input type="submit" name="<?=PATH_COMMENTS?>" class="btn btn-outline-primary btn-md rounded-0 ml-auto" value="Отравить">
                    </div>
                </form>
            </div>

            <!--Paginator-->
            <div class="btn-toolbar my-4 justify-content-between" role="toolbar" aria-label="Toolbar with button groups">

                <div class="btn-group" role="group" aria-label="First group">
                    <?php if ($previous): ?>
                        <a class="btn btn-outline-primary rounded-0" href="<?=PATH_ARTICLES?>/<?=$previous?>"><--</a>
                    <?php endif; ?>
                </div>

                <div class="btn-group" role="group" aria-label="First group">
                    <?php if ($next): ?>
                        <a class="btn btn-outline-primary rounded-0" href="<?=PATH_ARTICLES?>/<?=$next?>">--></a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</div>

<?php

include ($preview ? VIEW_FOOTER_ADMIN : VIEW_FOOTER);

?>
