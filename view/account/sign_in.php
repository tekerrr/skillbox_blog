<?php

include VIEW_HEADER;

?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height:70vh">
        <form class="form col-5" action="" method="post">
            <h3 class="text-center text-primary">Авторизация</h3>

            <div class="form-group">
                <?php $inputName = 'email'?>
                <label for="<?=$inputName?>" class="text-primary">Email:</label>
                <input type="email" id="<?=$inputName?>" name="<?=$inputName?>" autocomplete="username"
                       class="form-control rounded-0  <?=$fields[$inputName]['status'] ?? ''?>"
                       value="<?=$fields[$inputName]['value'] ?? ''?>">
                <?php include VIEW_TEMPLATE . '/form_invalid_message.php'; ?>
            </div>

            <div class="form-group">
                <?php $inputName = 'password'?>
                <label for="<?=$inputName?>" class="text-primary ">Пароль:</label>
                <input type="password" name="<?=$inputName?>" id="<?=$inputName?>" autocomplete="current-password"
                       class="form-control rounded-0 <?=$fields[$inputName]['status'] ?? ''?>"
                       value="<?=$fields[$inputName]['value'] ?? ''?>">
                <?php include VIEW_TEMPLATE . '/form_invalid_message.php'; ?>
            </div>

            <div class="row form-group mx-0">
                <input type="submit" name="<?=PATH_SIGN_IN?>" class="btn btn-primary btn-md rounded-0" value="Войти">
                <a class="btn btn-outline-primary rounded-0 ml-auto" href="<?=PATH_USERS?>/create">
                    Зарегистрироваться
                </a>
            </div>
        </form>
    </div>
</div>

<?php

include VIEW_FOOTER;

?>
