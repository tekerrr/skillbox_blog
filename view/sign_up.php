<?php

include VIEW_LAYOUT_DIR . 'header.php';

?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height:80vh">
        <form class="form col-5" action="" method="post">
            <h3 class="text-center text-primary">Регистрация</h3>

            <div class="form-group">
                <?php $inputName = 'email'?>
                <label for="<?=$inputName?>" class="text-primary">Email:</label>
                <input type="email" id="<?=$inputName?>" name="<?=$inputName?>" autocomplete="username"
                       class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$_POST[$inputName] ?? $user->email ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>

            <div class="form-group">
                <?php $inputName = 'name'?>
                <label for="<?=$inputName?>" class="text-primary">Имя:</label>
                <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                       class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$_POST[$inputName] ?? $user->email ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>

            <div class="form-group">
                <?php $inputName = 'password'?>
                <label for="<?=$inputName?>" class="text-primary ">Пароль:</label>
                <input type="password" name="<?=$inputName?>" id="<?=$inputName?>" autocomplete="new-password"
                       class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$_POST[$inputName] ?? $user->email ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>

            <div class="form-group">
                <?php $inputName = 'password2'?>
                <label for="<?=$inputName?>" class="text-primary ">Повторите пароль:</label><br>
                <input type="password" name="<?=$inputName?>" id="<?=$inputName?>" autocomplete="new-password"
                       class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$_POST[$inputName] ?? $user->email ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>

            <div class="form-check mb-3">
                <?php $inputName = 'rules_agree'?>
                <input type="checkbox" name="<?=$inputName?>" id="<?=$inputName?>"
                       class="form-check-input <?=$validStatus = $status[$inputName] ?? ''?>"
                        <?=isset($_POST[$inputName]) ? 'checked' : ''?>>
                <label class="form-check-label text-primary" for="<?=$inputName?>">
                    Согласен с <a href="?<?=PATH_RULES?>"><u>Правилами сайта</u></a>
                </label>

                <?php if ($validStatus == 'is-invalid'): ?>
                    <div class="invalid-feedback text-left">
                        Вы должны согласиться перед регистрацией
                    </div>
                <?php endif; ?>
            </div>

            <div class="row form-group mx-0">
                <input type="submit" name="submit_sign_up" class="btn btn-primary btn-md rounded-0" value="Зарегистрироваться">
                <a class="btn btn-outline-primary rounded-0 ml-auto" href="?<?=PATH_SIGN_IN?>">Войти</a>
            </div>

        </form>

    </div>
</div>

<?php

include VIEW_LAYOUT_DIR . 'footer.php';

?>
