<?php

include VIEW_LAYOUT_DIR . 'header.php';

?>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height:70vh">
        <form class="form col-5" action="" method="post">
            <h3 class="text-center text-primary">Смена пароля</h3>

            <div class="form-group">
                <?php $inputName = 'password'?>
                <label for="<?=$inputName?>" class="text-primary ">Старый:</label><br>
                <input type="password" name="<?=$inputName?>" id="<?=$inputName?>" autocomplete="current-password"
                       class="form-control rounded-0 <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$_POST[$inputName] ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>

            <div class="form-group">
                <?php $inputName = 'new_password'?>
                <label for="<?=$inputName?>" class="text-primary ">Новый:</label><br>
                <input type="password" name="<?=$inputName?>" id="<?=$inputName?>" autocomplete="new-password"
                       class="form-control rounded-0 <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$_POST[$inputName] ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>

            <div class="form-group">
                <?php $inputName = 'new_password2'?>
                <label for="<?=$inputName?>" class="text-primary ">Повторите пароль:</label><br>
                <input type="password" name="<?=$inputName?>" id="<?=$inputName?>" autocomplete="new-password"
                       class="form-control rounded-0 <?=$validStatus = $status[$inputName] ?? ''?>"
                       value="<?=$_POST[$inputName] ?? ''?>">
                <?php include VIEW_TEMPLATE . 'form_invalid_message.php'; ?>
            </div>

            <?php if (! empty($error)): ?>
                <div class="alert alert-primary" role="alert">
                    Неверный email или пароль
                </div>
            <?php endif ?>

            <div class="row form-group mx-0">
                <input type="submit" name="submit_change_password" class="btn btn-primary btn-md rounded-0" value="Изменить">
            </div>
        </form>
    </div>
</div>

<?php

include VIEW_LAYOUT_DIR . 'footer.php';

?>
