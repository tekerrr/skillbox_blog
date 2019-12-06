<?php

$title = 'Регистрация';
include VIEW_HEADER;

?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height:80vh">
        <form class="form col-5" action="" method="post">
            <h3 class="text-center text-primary">Регистрация</h3>

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
                    'name' => ($name = 'name'),
                    'label' => 'Имя',
                    'field' => $fields[$name] ?? [],
                ]); ?>
            </div>

            <div class="form-group">
                <?php includeView('template.input.input', [
                    'name' => ($name = 'password'),
                    'label' => 'Новый:',
                    'field' => $fields[$name] ?? [],
                    'type' => 'password',
                    'add' => 'autocomplete="new-password"',
                ]); ?>
            </div>

            <div class="form-group">
                <?php includeView('template.input.input', [
                    'name' => ($name = 'password2'),
                    'label' => 'Повторите пароль:',
                    'field' => $fields[$name] ?? [],
                    'type' => 'password',
                    'add' => 'autocomplete="new-password"',
                ]); ?>
            </div>

            <div class="form-check mb-3">
                <?php includeView('template.input.checkbox_rules', [
                    'name' => ($name = 'rules_agree'),
                    'field' => $fields[$name] ?? [],
                ]); ?>
            </div>

            <div class="row form-group mx-0">
                <input type="submit" name="<?=PATH_SIGN_UP?>" class="btn btn-primary btn-md rounded-0" value="Зарегистрироваться">
                <a class="btn btn-outline-primary rounded-0 ml-auto" href="<?=PATH_SIGN_IN?>">Войти</a>
            </div>

        </form>

    </div>
</div>

<?php

include VIEW_FOOTER;

?>
