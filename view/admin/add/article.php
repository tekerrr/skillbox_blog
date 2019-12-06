<?php

include VIEW_LAYOUT_DIR . 'admin_header.php';

?>

<div class="container">

    <form class="form pt-4" enctype="multipart/form-data" action="" method="post">
        <h3 class="text-center text-primary"><?=$title?></h3>

        <div class="form-group">
            <?php $inputName = 'title'?>
            <label for="<?=$inputName?>" class="text-primary">Заголовок:</label>
            <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                   class="form-control rounded-0  <?=$validStatus = $status[$inputName] ?? ''?>"
                   value="<?=$_POST[$inputName] ?? ''?>">
            <?php include VIEW_TEMPLATE . 'form_invalid_message.php' ?>
        </div>

        <div class="form-group">
            <?php $inputName = 'abstract'?>
            <label for="<?=$inputName?>" class="text-primary ">Краткое описание (поддерживает теги):</label>
            <textarea class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                      name="<?=$inputName?>" id="<?=$inputName?>" rows="3"><?=$_POST[$inputName] ?? ''?></textarea>
            <?php include VIEW_TEMPLATE . 'form_invalid_message.php' ?>
        </div>

        <div class="form-group">
            <?php $inputName = 'text'?>
            <label for="<?=$inputName?>" class="text-primary ">Содержимое (поддерживает теги):</label>
            <textarea class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                      name="<?=$inputName?>" id="<?=$inputName?>" rows="10"><?=$_POST[$inputName] ?? ''?></textarea>
            <?php include VIEW_TEMPLATE . 'form_invalid_message.php' ?>
        </div>

        <div class="form-group mb-3">
            <?php $inputName = 'article'?>
            <label for="<?=$inputName?>" class="text-primary">Изображение:</label>
            <input type="file" id="<?=$inputName?>" name="<?=$inputName?>"
                   class="form-control-file <?=$validStatus = $status[$inputName] ?? ''?>"
                   value="<?=$_POST[$inputName] ?? ''?>">
            <?php include VIEW_TEMPLATE . 'form_invalid_message.php' ?>
        </div>

        <div class="row form-group mx-0">
            <input type="submit" name="submit_add_article" class="btn btn-primary btn-md rounded-0" value="Создать">
            <a class="btn btn-outline-primary rounded-0 ml-3" href="?<?=PATH_ADMIN_LIST?>/articles/1">
                Отмена
            </a>
        </div>
    </form>

    <?php include VIEW_TEMPLATE . 'error_alerts.php' ?>
</div>

<?php

include VIEW_LAYOUT_DIR . 'admin_footer.php';

?>
