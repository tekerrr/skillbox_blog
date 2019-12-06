<?php

$title = 'Редактирование пользователя';
include VIEW_HEADER_ADMIN;

?>

<div class="container my-4">
    <h1 class="text text-center pb-5">Личный кабинет</h1>

    <div class="row justify-content-center">

        <!--    Avatar    -->
        <div class="col-4">
            <img src="/img/user/<?=$user['image'] ?? 'default_avatar.png'?>" alt="post img" class="img-fluid ">
            <div class="row justify-content-start align-items-start py-3">
                <form class="form" enctype="multipart/form-data" action="" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="<?=PATH_USERS?>/<?=$user['id']?>/upload_avatar" value="">
                    <label class="btn btn-primary rounded-0 mx-3 my-0">
                        Загрузить аватар <input type="file" name="img_user" onchange="form.submit()" hidden>
                    </label>
                </form>
                <form class="form" action="" method="post">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="submit" name="<?=PATH_USERS?>/<?=$user['id']?>/delete_avatar" class="btn btn-outline-primary rounded-0" value="Удалить">
                </form>
            </div>
        </div>

        <div class="col-4">
            <!--    User Data    -->
            <form class="form" action="" method="post">
                <input type="hidden" name="id" value="<?=$user['id']?>">

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
                    <input type="submit" name="<?=PATH_USERS?>/<?=$user['id']?>" class="btn btn-primary btn-md rounded-0"
                    value="Сохранить">
                </div>
            </form>

        </div>

    </div>

    <div class="row py-3 border-bottom ml-0 w-50">
        <div class="col-4"><b>Роль</b></div>
        <div class=""><b>Статус</b></div>
    </div>

    <?php $groups = [ADMINS, AUTHORS, USERS]; ?>
    <?php foreach ($groups as $group): ?>
        <div class="row py-3 border-bottom ml-0 align-items-start w-50">
            <div class="col-4"><b><?=$group?></b></div>
            <div class="">
                <form method="post">
                    <text class ="<?=($active = in_array($group, $user['groups'])) ? 'text-success' : 'text-danger'?>">
                        <?=$active ? 'Состоит' : 'Не состоит'?>
                    </text>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="group" value="<?=$group?>">
                    <input type="submit" name="<?=PATH_USERS?>/<?=$user['id']?>/<?=$active ? 'leave_group' : 'join_group'?>" class="btn btn-outline-primary rounded-0 btn-sm  ml-1"
                           value="Сменить">
                </form>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<?php

include VIEW_FOOTER_ADMIN;

?>
