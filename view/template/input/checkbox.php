<input type="checkbox" name="<?=$name?>" id="<?=$name?>"
       class="form-check-input <?=$status = $field['status'] ?? ''?>"
    <?=isset($field['value']) ? 'checked' : ''?>>
<label class="form-check-label text-primary" for="<?=$name?>"><?=$label ?? 'label text'?></label>
<?php includeViewProvided($status == 'is-invalid', 'template.input.error', ['message' => $field['message'] ?? '']); ?>
