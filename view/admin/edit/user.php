<?php

include VIEW_LAYOUT_DIR . 'admin_header.php';

?>

<div class="container my-4">
    <h1 class="text text-center pb-5">Личный кабинет</h1>

    <div class="row justify-content-center">

        <!--    Avatar    -->
        <div class="col-4">
            <img src="/img/user/<?=$user['image'] ?? 'default_avatar.png'?>" alt="post img" class="img-fluid ">
            <div class="row justify-content-start py-3">
                <form class="form" enctype="multipart/form-data" action="" method="post">
                    <input type="hidden" name="id" value="<?=$user['id']?>">
                    <input type="hidden" name="submit_upload_avatar_for_user" value="upload">
                    <label class="btn btn-primary rounded-0 mx-3">
                        Загрузить аватар <input type="file" name="img_user" onchange="form.submit()" hidden>
                    </label>
                </form>
                <label><a class="btn btn-outline-primary rounded-0" href="?delete_avatar_for_user/<?=$user['id']?>">Удалить</a></label>
            </div>
            <?php include VIEW_TEMPLATE . 'error_alerts.php' ?>
        </div>

        <div class="col-4">
            <!--    User Data    -->
            <form class="form" action="" method="post">
                <input type="hidden" name="id" value="<?=$user['id']?>">

                <div class="form-group row justify-content-start">
                    <?php $inputName = 'email'?>
                    <label for="<?=$inputName?>" class="text-primary col-3 align-self-end">Email</label>
                    <input type="email" id="<?=$inputName?>" name="<?=$inputName?>"
                           class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                           value="<?=$fieldValue[$inputName] ?? ''?>">
                    <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
                </div>

                <div class="form-group row justify-content-start">
                    <?php $inputName = 'name'?>
                    <label for="<?=$inputName?>" class="text-primary col-3 align-self-end">Имя</label>
                    <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                           class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                           value="<?=$fieldValue[$inputName] ?? ''?>">
                    <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
                </div>

                <div class="form-group row">
                    <?php $inputName = 'about'?>
                    <label for="<?=$inputName?>" class="text-primary col-3 pt-1">О себе</label>
                    <textarea class="form-control rounded-0 col" name="<?=$inputName?>" id="<?=$inputName?>"
                              rows="3"><?=$fieldValue[$inputName] ?? ''?></textarea>
                </div>
                <div class="form-group row">
                    <div class="col"></div>
                    <input type="submit" name="submit_edit_user" class="btn btn-outline-primary btn-md rounded-0 col-4" value="Сохранить">
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
                    <input type="hidden" name="id" value="<?=$user['id']?>">
                    <input type="hidden" name="group" value="<?=$group?>">
                    <input type="hidden" name="active" value="<?=$active?>">
                    <input type="submit" class="btn btn-outline-primary rounded-0 btn-sm  ml-1"
                           name="submit_edit_user_group" value="Сменить">
                </form>
            </div>
        </div>
    <?php endforeach; ?>

</div>

<?php

include VIEW_LAYOUT_DIR . 'admin_footer.php';

?>
