<?php

include VIEW_HEADER_ADMIN;

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
                       class="form-control rounded-0 pl-3 <?=$fields[$inputName]['status'] ?? ''?>"
                       value="<?=$fields[$inputName]['value'] ?? ''?>">
                <?php include VIEW_TEMPLATE . '/form_invalid_message.php'; ?>
            </div>
        </div>

        <div class="form-row align-items-center pt-2">
            <?php $inputName = 'articles_per_header'?>
            <div class="col-6">
                <label for="<?=$inputName?>">Количество статей на в Панели навигации</label>
            </div>
            <div class="col-1">
                <input type="text" id="<?=$inputName?>" name="<?=$inputName?>"
                       class="form-control rounded-0 pl-3 <?=$fields[$inputName]['status'] ?? ''?>"
                       value="<?=$fields[$inputName]['value'] ?? ''?>">
                <?php include VIEW_TEMPLATE . '/form_invalid_message.php'; ?>
            </div>
        </div>

        <div class="form-row align-items-center pt-2">
            <?php $inputName = 'items_per_page'?>
            <div class="col-6">
                <label class="" for="items">Количество элементов на страницах "Административного раздела"</label>
            </div>
            <div class="col-1">
                <select class="form-control rounded-0" name="items_per_page_value" id="items">
                    <option value="10"  <?=$fields[$inputName]['value'] == '10' ? 'selected' : ''?>>10</option>
                    <option value="20"  <?=$fields[$inputName]['value'] == '20' ? 'selected' : ''?>>20</option>
                    <option value="50"  <?=$fields[$inputName]['value'] == '50' ? 'selected' : ''?>>50</option>
                    <option value="200" <?=$fields[$inputName]['value'] == '200' ? 'selected' : ''?>>200</option>
                    <option value="all" <?=$fields[$inputName]['value'] == 'all' ? 'selected' : ''?>>Все</option>
                </select>
            </div>
        </div>

        <div class="form-group pt-2">
            <input type="hidden" name="_method" value="PUT">
            <input type="submit" name="<?=PATH_ADMIN_SETTINGS?>" class="btn btn-primary btn-md rounded-0" value="Сохранить">
        </div>
    </form>




</div>

<?php

include VIEW_FOOTER_ADMIN;

?>
