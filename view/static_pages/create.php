<?php

$title = 'Добавить статичную страницу';
include VIEW_HEADER_ADMIN;

?>

<div class="container">

    <form class="form pt-4" action="" method="post">
        <h3 class="text-center text-primary"><?=$title?></h3>

        <div class="form-group">
            <?php includeView('template.input.input', [
                'name' => ($name = 'title'),
                'label' => 'Заголовок:',
                'field' => $fields[$name] ?? [],
            ]); ?>
        </div>

        <div class="form-group">
            <?php includeView('template.input.area', [
                'name' => ($name = 'text'),
                'label' => 'Содержимое (поддерживает теги):',
                'field' => $fields[$name] ?? [],
                'rows' => '10',
            ]); ?>
        </div>

        <div class="form-check mb-3">
            <?php includeView('template.input.checkbox', [
                'name' => ($name = 'p_teg'),
                'label' => 'Заключить каждый абзац в тэг &lt;p&gt;',
                'field' => $fields[$name] ?? [],
            ]); ?>
        </div>

        <div class="row form-group mx-0">
            <input type="submit" name="<?=PATH_STATIC_PAGES?>" class="btn btn-primary btn-md rounded-0"
                   value="Создать">
            <a class="btn btn-outline-primary rounded-0 ml-3" href="<?=PATH_ADMIN_LIST?>/static_pages">
                Отмена
            </a>
        </div>
    </form>
</div>

<?php

include VIEW_FOOTER_ADMIN;

?>
