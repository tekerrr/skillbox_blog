<?php

$title = 'Авторизация';
include VIEW_HEADER;

?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height:70vh">
        <form class="form col-5" action="" method="post">
            <h3 class="text-center text-primary">Авторизация</h3>

            <div class="form-group">
                <?php includeView('template.input.input', [
                    'name' => ($name = 'email'),
                    'label' => 'Email:',
                    'field' => $fields[$name] ?? [],
                    'type' => 'email',
                    'add' => 'autocomplete="username"',
                ]); ?>
            </div>

            <div class="form-group">
                <?php includeView('template.input.input', [
                    'name' => ($name = 'password'),
                    'label' => 'Пароль:',
                    'field' => $fields[$name] ?? [],
                    'type' => 'password',
                    'add' => 'autocomplete="current-password"',
                ]); ?>
            </div>

            <div class="row form-group mx-0">
                <input type="submit" name="<?=PATH_SIGN_IN?>" class="btn btn-primary btn-md rounded-0" value="Войти">
                <a class="btn btn-outline-primary rounded-0 ml-auto" href="<?=PATH_SIGN_UP?>">
                    Зарегистрироваться
                </a>
            </div>
        </form>
    </div>
</div>

<?php

include VIEW_FOOTER;

?>
