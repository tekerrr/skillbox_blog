<?php

$title = 'Смена пароля';
include VIEW_HEADER;

?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height:70vh">
        <form class="form col-5" action="" method="post">
            <h3 class="text-center text-primary">Смена пароля</h3>

            <div class="form-group">
                <?php includeView('template.input.input', [
                    'name' => ($name = 'password'),
                    'label' => 'Старый:',
                    'field' => $fields[$name] ?? [],
                    'type' => 'password',
                    'add' => 'autocomplete="current-password"',
                ]); ?>
            </div>

            <div class="form-group">
                <?php includeView('template.input.input', [
                    'name' => ($name = 'new_password'),
                    'label' => 'Новый:',
                    'field' => $fields[$name] ?? [],
                    'type' => 'password',
                    'add' => 'autocomplete="new-password"',
                ]); ?>
            </div>

            <div class="form-group">
                <?php includeView('template.input.input', [
                    'name' => ($name = 'new_password2'),
                    'label' => 'Повторите пароль:',
                    'field' => $fields[$name] ?? [],
                    'type' => 'password',
                    'add' => 'autocomplete="new-password"',
                ]); ?>
            </div>

            <div class="row form-group mx-0">
                <input type="hidden" name="_method" value="PUT">
                <input type="submit" name="<?=PATH_PASSWORD?>" class="btn btn-primary btn-md rounded-0" value="Изменить">
            </div>
        </form>
    </div>
</div>

<?php

include VIEW_FOOTER;

?>
