<?php

include VIEW_HEADER_ADMIN;

?>

<div class="container">

    <form class="form pt-4" enctype="multipart/form-data" action="" method="post">
        <h3 class="text-center text-primary"><?=$title?></h3>

        <div class="form-group">
            <?php $inputName = 'title'?>
            <label for="<?=$inputName?>" class="text-primary">Заголовок:</label>
            <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                   class="form-control rounded-0  <?=$fields[$inputName]['status'] ?? ''?>"
                   value="<?=$fields[$inputName]['value'] ?? ''?>">
            <?php include VIEW_TEMPLATE . '/form_invalid_message.php' ?>
        </div>

        <div class="form-group">
            <?php $inputName = 'abstract'?>
            <label for="<?=$inputName?>" class="text-primary ">Краткое описание (поддерживает теги):</label>
            <textarea class="form-control rounded-0 col <?=$fields[$inputName]['status'] ?? ''?>"
                      name="<?=$inputName?>" id="<?=$inputName?>" rows="3"><?=$fields[$inputName]['value'] ?? ''?></textarea>
            <?php include VIEW_TEMPLATE . '/form_invalid_message.php' ?>
        </div>

        <div class="form-group">
            <?php $inputName = 'text'?>
            <label for="<?=$inputName?>" class="text-primary ">Содержимое (поддерживает теги):</label>
            <textarea class="form-control rounded-0 col <?=$fields[$inputName]['status'] ?? ''?>"
                      name="<?=$inputName?>" id="<?=$inputName?>" rows="10"><?=$fields[$inputName]['value'] ?? ''?></textarea>
            <?php include VIEW_TEMPLATE . '/form_invalid_message.php' ?>
        </div>

        <div class="form-check mb-3">
            <?php $inputName = 'p_teg'?>
            <input type="checkbox" name="<?=$inputName?>" id="<?=$inputName?>"
                   class="form-check-input <?=$fields[$inputName]['status'] ?? ''?>"
                <?=isset($fields[$inputName]['value']) ? 'checked' : ''?>>
            <label class="form-check-label text-primary" for="<?=$inputName?>">
                Заключить каждый абзац в тэг &lt;p&gt;
            </label>
        </div>

        <div class="form-group mb-3">
            <?php $inputName = 'img_article'?>
            <label for="<?=$inputName?>" class="text-primary">
                Изображение (для изменеия загрузите новый файл):
            </label>
            <div class="mb-3 w-50">
                <img src="/img/article/<?=$article['image'] ?? 'default_image.png'?>" alt="post img" class="img-fluid">
            </div>
            <input type="file" id="<?=$inputName?>" name="<?=$inputName?>"
                   class="form-control-file <?=$fields[$inputName]['status'] ?? ''?>">
            <?php include VIEW_TEMPLATE . '/form_invalid_message.php' ?>
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
