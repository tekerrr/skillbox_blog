<?php

$title = 'Редактировать статью';
include VIEW_HEADER_ADMIN;

?>

<div class="container">

    <form class="form pt-4" enctype="multipart/form-data" action="" method="post">
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
                'name' => ($name = 'abstract'),
                'label' => 'Краткое описание (поддерживает теги):',
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

        <div class="form-group mb-3">
            <div class="mb-3 w-50 mt-3">
                <div class="text-primary">Изображение: </div>
                <img src="/img/article/<?=$article['image'] ?? 'default_image.png'?>" alt="post img" class="img-fluid">
            </div>
            <?php includeView('template.input.file', [
                'name' => ($name = 'img_article'),
                'label' => 'Для изменеия загрузите новый файл:',
                'field' => $fields[$name] ?? [],
            ]); ?>
        </div>

        <div class="row form-group mx-0">
            <input type="submit" name="/articles/<?=$article['id']?>" class="btn btn-primary btn-md rounded-0"
                   value="Сохранить">
            <input type="hidden" name="_method" value="PUT">
            <a class="btn btn-outline-primary rounded-0 ml-3" href="<?=PATH_ADMIN_LIST?>/articles">
                Отмена
            </a>
        </div>
    </form>
</div>

<?php

include VIEW_FOOTER_ADMIN;

?>
