<?php

$title = 'Главная';
include VIEW_HEADER;

?>

<div class="container pt-4">

    <?php foreach ($articles as $article): ?>
        <!--  Article  -->
        <div class="my-4">
            <div class="media">

                <div class="col-2 mr-3">
                    <img src="/img/article/<?=$article['image'] ?? 'default_image.png'?>"
                         alt="post img" class="img-fluid">
                </div>

                <div class="media-body">
                    <h3><?=$article['title']?></h3>
                    <p><?=$article['abstract']?></p>

                    <div class="row mx-0 justify-content-end">
                        <p class=""><i><?=$article['create_time']?></i></p>
                        <a class="btn btn-outline-primary rounded-0 ml-auto"
                           href="<?=PATH_ARTICLES?>/<?=$article['id']?>">
                            ПОДРОБНЕЕ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!--Paginator-->
    <?php includeViewProvided($paginator->isNeeded(), 'template.paginator', ['paginator' => $paginator]); ?>

    <!--Подписка-->
    <?php if (! $sub): ?>
        <div class="row my-4 px-0">
            <div class="ml-auto col-5">
                <form class="form" action="" method="post">
                    <div class="input-group">

                        <?php if ($userEmail): ?>
                            <input type="email" name="email" class="form-control rounded-0"
                                   value="<?=$userEmail?>" readonly>
                        <?php else: ?>
                            <?php $inputName = 'email'?>
                            <input type="email" name="<?=$inputName?>" placeholder="Enter email"
                                   class="form-control rounded-0  <?=$fields[$inputName]['status'] ?? ''?>"
                                   value="<?=$fields[$inputName]['value'] ?? ''?>">
                        <?php endif; ?>
                        <input type="submit" name="<?=PATH_SUBSCRIBERS?>" class="btn btn-primary btn-md rounded-0"
                        value="Подписаться на рассылку">

                        <div class="invalid-feedback text-left">
                            <?=$fields[$inputName]['message'] ?? 'Ошибка при заполнении поля'?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php

include VIEW_FOOTER;

?>
