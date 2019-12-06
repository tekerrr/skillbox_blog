<?php

include VIEW_LAYOUT_DIR . 'admin_header.php';

?>

<div class="container pt-4">
    <div class="row justify-content-center my-3">
        <h1>Настройки</h1>
    </div>

    <form method="post">
        <div class="form-row align-items-center pt-2">
            <?php $inputName = 'articles_per_page'?>
            <div class="col-6">
                <label for="<?=$inputName?>">Количество статей на главной странице</label>
            </div>
            <div class="col-1">
                <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                       class="form-control rounded-0 pl-3 <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$fieldValue[$inputName] ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>
        </div>

        <div class="form-row align-items-center pt-2">
            <?php $inputName = 'articles_per_header'?>
            <div class="col-6">
                <label for="<?=$inputName?>">Количество статей на в Панели навигации</label>
            </div>
            <div class="col-1">
                <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                       class="form-control rounded-0 pl-3 <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$fieldValue[$inputName] ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>
        </div>

        <div class="form-row align-items-center pt-2">
            <?php $inputName = 'items_per_page'?>
            <div class="col-6">
                <label class="" for="items">Количество элементов на страницах "Административного раздела"</label>
            </div>
            <div class="col-1">
                <select class="form-control rounded-0" name="items_per_page" id="items">
                    <option value="10"  <?=$fieldValue[$inputName] == '10' ? 'selected' : ''?>>10</option>
                    <option value="20"  <?=$fieldValue[$inputName] == '20' ? 'selected' : ''?>>20</option>
                    <option value="50"  <?=$fieldValue[$inputName] == '50' ? 'selected' : ''?>>50</option>
                    <option value="200" <?=$fieldValue[$inputName] == '200' ? 'selected' : ''?>>200</option>
                    <option value="all" <?=$fieldValue[$inputName] == 'all' ? 'selected' : ''?>>Все</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <input type="submit" name="submit_edit_settings" class="btn btn-primary btn-md rounded-0" value="Сохранить">
        </div>
    </form>




</div>

<?php

include VIEW_LAYOUT_DIR . 'admin_footer.php';

?>
