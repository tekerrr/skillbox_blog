<?php if (isset($fields[$inputName]['status']) && $fields[$inputName]['status'] == 'is-invalid'): ?>
    <div class="invalid-feedback">
        <?=$fields[$inputName]['message'] ?? 'Ошибка при заполнении поля'?>
    </div>
<?php endif; ?>