<?php

$title = 'Настройки';
include VIEW_HEADER_ADMIN;

?>

<div class="container pt-4">
    <div class="row justify-content-center my-3">
        <h1>Настройки</h1>
    </div>

    <form method="post">
        <?php includeView('template.input.setting', [
            'name' => ($name = 'articles_per_page'),
            'label' => 'Количество статей на главной странице',
            'field' => $fields[$name] ?? [],
        ]); ?>

        <?php includeView('template.input.setting', [
            'name' => ($name = 'articles_per_header'),
            'label' => 'Количество статей на в Панели навигации',
            'field' => $fields[$name] ?? [],
        ]); ?>

        <div class="form-row align-items-center pt-2">
            <?php $name = 'items_per_page_value'?>
            <div class="col-6">
                <label class="" for="items">Количество элементов на страницах "Административного раздела"</label>
            </div>
            <div class="col-1">
                <select class="form-control rounded-0" name="items_per_page_value" id="items">
                    <?php $options = ['10' => '10', '20' => '20', '50' => '50', '200' => '200', 'Все' => 'all']; ?>
                    <?php foreach ($options as $key => $value): ?>
                        <option value="<?=$value?>"  <?=$fields[$name]['value'] == $value ? 'selected' : ''?>><?=$key?></option>
                    <?php endforeach; ?>
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
