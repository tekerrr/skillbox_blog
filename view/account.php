<?php

include VIEW_LAYOUT_DIR . 'header.php';

?>

<div class="container my-4">
    <h1 class="text text-center pb-5">Личный кабинет</h1>

    <div class="row justify-content-center">

        <!--    Avatar    -->
        <div class="col-4">
            <img src="/img/avatar/<?=$user['image'] ?? 'default_avatar.png'?>" alt="post img" class="img-fluid ">
            <div class="row justify-content-start py-3">
                <form class="form" enctype="multipart/form-data" action="" method="post">
                    <input type="hidden" name="submit_upload_avatar" value="upload">
                    <label class="btn btn-primary rounded-0 mx-3">
                        Загрузить аватар <input type="file" name="avatar" onchange="form.submit()" hidden>
                    </label>
                </form>
                <label><a class="btn btn-outline-primary rounded-0" href="?delete_avatar">Удалить</a></label>
            </div>
            <?php include VIEW_TEMPLATE . 'error_alerts.php' ?>
        </div>

        <div class="col-4">
            <!--    User Data    -->
            <form class="form" action="" method="post">

                <div class="form-group row justify-content-start">
                    <?php $inputName = 'email'?>
                    <label for="<?=$inputName?>" class="text-primary col-3 align-self-end">Email</label>
                    <input type="email" id="<?=$inputName?>" name="<?=$inputName?>" autocomplete="username"
                           class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                           value="<?=$_POST[$inputName] ?? $user['email'] ?? ''?>">
                    <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
                </div>

                <div class="form-group row justify-content-start">
                    <?php $inputName = 'name'?>
                    <label for="<?=$inputName?>" class="text-primary col-3 align-self-end">Имя</label>
                    <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                           class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                           value="<?=$_POST[$inputName] ?? $user['name'] ?? ''?>">
                    <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
                </div>

                <div class="form-group row justify-content-end">
                    <?php $inputName = 'password'?>
                    <text class="text-primary col align-self-center">Пароль</text>
                    <a class="btn btn-outline-secondary rounded-0 col-4 border" href="?<?=PATH_CHANGE_PASSWORD?>">Сменить</a>
                </div>

                <div class="form-group row">
                    <label for="about" class="text-primary col-3 pt-1">О себе</label>
                    <textarea class="form-control rounded-0 col" name="about" id="about" rows="3"><?=$user['about'] ?? ''?></textarea>
                </div>
                <div class="form-group row">
                    <div class="col"></div>
                    <input type="submit" name="submit_update_account" class="btn btn-outline-primary btn-md rounded-0 col-4" value="Сохранить">
                </div>
            </form>

            <!--    Subscribe    -->
            <form class="form row form-group" action="" method="post">
                <?php if ($sub): ?>
                    <label for="unsubscribe" class="text-primary col align-self-end">Подписка оформлена</label>
                    <a class="btn btn-outline-danger rounded-0 col-4" id="unsubscribe"
                       href="?unsubscribe/<?=$sub['id']?>/<?=$sub['hash']?>/">Отписаться</a>
                <?php else: ?>
                    <label for="subscribe" class="text-primary col align-self-end">Подписка на новые статьи</label>
                    <input type="submit" name="submit_subscribe" class="btn btn-primary btn-md rounded-0 col-4"
                           id="subscribe" value="Оформить">
                    <input type="hidden" name="email" value="<?=$user['email']?>">
                <?php endif; ?>
            </form>

        </div>

    </div>

</div>

<?php

include VIEW_LAYOUT_DIR . 'footer.php';

?>
