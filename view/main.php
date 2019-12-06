<?php

use App\Controller\Auth;

include VIEW_LAYOUT_DIR . 'header.php';

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
                           href="?<?=PATH_ARTICLE?>/<?=$article['id']?>">
                            ПОДРОБНЕЕ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!--Paginator-->
    <?php if ($paginator->isNeeded()):
        include VIEW_TEMPLATE . 'paginator.php';
    endif; ?>

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
                            <input type="email" name="email" placeholder="Enter email"
                                   class="form-control rounded-0  <?=$validStatus = $status['email'] ?? ''?>"
                                   value="<?=$_POST['email'] ?? ''?>">
                        <?php endif; ?>

                        <input type="hidden" name="current_main_page" value="<?=$paginator->getCurrentPage()?>">

                        <input type="submit" name="submit_subscribe" class="btn btn-primary btn-md rounded-0"
                               value="Подписаться на рассылку">

                        <?php if (! $userEmail && $validStatus == 'is-invalid'): ?>
                            <div class="invalid-feedback text-left">
                                <?=$message['email'] ?? 'Ошибка при заполнении поля'?>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php

include VIEW_LAYOUT_DIR . 'footer.php';

?>
