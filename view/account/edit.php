<?php

$title = 'Личный кабинет';
include VIEW_HEADER;

?>

<div class="container my-4">
    <h1 class="text text-center pb-5">Личный кабинет</h1>

    <div class="row justify-content-center">

        <!--    Avatar    -->
        <div class="col-4">
            <img src="/img/user/<?=$user['image'] ?? 'default_avatar.png'?>" alt="post img" class="img-fluid ">
            <div class="row justify-content-start py-3">
                <form class="form" enctype="multipart/form-data" action="" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_avatar" value="">
                    <input type="hidden" name="<?=PATH_ACCOUNT?>" value="">
                    <label class="btn btn-primary rounded-0 mx-3 my-0">
                        Загрузить аватар <input type="file" name="img_user" onchange="form.submit()" hidden>
                    </label>
                    <input type="submit" name="_delete" class="btn btn-outline-primary rounded-0" value="Удалить">
                </form>
            </div>
        </div>

        <div class="col-4">
            <!--    User Data    -->
            <form class="form" action="" method="post">

                <div class="form-group row justify-content-start">
                    <?php includeView('template.input.input', [
                        'name' => ($name = 'email'),
                        'label' => 'Email',
                        'field' => $fields[$name] ?? [],
                        'type' => 'email',
                        'addLabelClass' => 'col-3 align-self-end',
                        'addInputClass' => 'col',
                        'add' => 'autocomplete="username"',
                    ]); ?>
                </div>

                <div class="form-group row justify-content-start">
                    <?php includeView('template.input.input', [
                        'name' => ($name = 'name'),
                        'label' => 'Имя',
                        'field' => $fields[$name] ?? [],
                        'addLabelClass' => 'col-3 align-self-end',
                        'addInputClass' => 'col',
                    ]); ?>
                </div>

                <div class="form-group row justify-content-end">
                    <text class="text-primary col align-self-center">Пароль</text>
                    <a class="btn btn-outline-secondary rounded-0 col-4 border" href="<?=PATH_PASSWORD?>">Сменить</a>
                </div>

                <div class="form-group row">
                    <?php includeView('template.input.area', [
                        'name' => ($name = 'about'),
                        'label' => 'О себе',
                        'field' => $fields[$name] ?? [],
                        'addLabelClass' => 'col-3 pt-1',
                        'addInputClass' => 'col',
                    ]); ?>
                </div>
                <div class="form-group row">
                    <div class="col"></div>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="submit" name="<?=PATH_ACCOUNT?>" class="btn btn-primary btn-md rounded-0"
                           value="Сохранить">
                </div>
            </form>

            <!--    Subscribe    -->
            <form class="form row form-group" action="" method="post">
                <?php if ($sub): ?>
                    <label for="unsubscribe" class="text-primary col align-self-end">Подписка оформлена</label>
                    <a class="btn btn-outline-danger rounded-0 col-4" id="unsubscribe"
                    href="<?=PATH_UNSUBSCRIBE?>/<?=$sub['id']?>/<?=$sub['hash']?>?from=<?=PATH_ACCOUNT?>">Отписаться</a>
                <?php else: ?>
                    <label for="subscribe" class="text-primary col align-self-end">Подписка на новые статьи</label>
                    <input type="hidden" name="email" value="<?=$user['email']?>">
                    <input type="submit" name="<?=PATH_SUBSCRIBERS?>" class="btn btn-primary btn-md rounded-0 col-4"
                           id="subscribe" value="Оформить">
                <?php endif; ?>
            </form>

        </div>

    </div>

</div>

<?php

include VIEW_FOOTER;

?>
