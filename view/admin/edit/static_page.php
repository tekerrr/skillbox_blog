<?php

include VIEW_LAYOUT_DIR . 'admin_header.php';

?>

<div class="container">

    <form class="form pt-4" action="" method="post">
        <h3 class="text-center text-primary"><?=$title?></h3>
        <?php if ($staticPage): ?>
            <input type="hidden" name="id" value="<?=$staticPage['id']?>">
        <?php endif; ?>

        <div class="form-group">
            <?php $inputName = 'title'?>
            <label for="<?=$inputName?>" class="text-primary">Заголовок:</label>
            <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                   class="form-control rounded-0  <?=$validStatus = $status[$inputName] ?? ''?>"
                   value="<?=$fieldValue[$inputName] ?? ''?>">
            <?php include VIEW_TEMPLATE . 'form_invalid_message.php' ?>
        </div>

        <div class="form-group">
            <?php $inputName = 'text'?>
            <label for="<?=$inputName?>" class="text-primary ">Содержимое (поддерживает теги):</label>
            <textarea class="form-control rounded-0 col <?=$validStatus = $status[$inputName] ?? ''?>"
                      name="<?=$inputName?>" id="<?=$inputName?>" rows="10"><?=$fieldValue[$inputName] ?? ''?></textarea>
            <?php include VIEW_TEMPLATE . 'form_invalid_message.php' ?>
        </div>

        <div class="form-check mb-3">
            <?php $inputName = 'p_teg'?>
            <input type="checkbox" name="<?=$inputName?>" id="<?=$inputName?>"
                   class="form-check-input <?=$validStatus = $status[$inputName] ?? ''?>"
                <?=isset($_POST[$inputName]) ? 'checked' : ''?>>
            <label class="form-check-label text-primary" for="<?=$inputName?>">
                Заключить каждый абзац в тэг &lt;p&gt;
            </label>
        </div>

        <div class="row form-group mx-0">
            <input type="submit" name="submit_<?=$staticPage ? 'edit' : 'add'?>_static_page" class="btn btn-primary btn-md rounded-0"
                   value="<?=$staticPage ? 'Сохранить' : 'Создать'?>">
            <a class="btn btn-outline-primary rounded-0 ml-3" href="?<?=PATH_ADMIN_LIST?>/static_pages/1">
                Отмена
            </a>
        </div>
    </form>
</div>

<?php

include VIEW_LAYOUT_DIR . 'admin_footer.php';

?>
