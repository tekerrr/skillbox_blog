<?php if ($validStatus == 'is-invalid'): ?>
    <div class="invalid-feedback">
        <?=$message[$inputName] ?? 'Ошибка при заполнении поля'?>
    </div>
<?php endif; ?>