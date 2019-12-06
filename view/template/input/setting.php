<div class="form-row align-items-center pt-2">
    <div class="col-6">
        <label for="<?=$name?>"><?=$label ?? 'label text'?></label>
    </div>
    <div class="col-1">
        <input type="<?=$type ?? 'text'?>" id="<?=$name?>" name="<?=$name?>"
               class="form-control rounded-0 pl-3 <?=$status = $field['status'] ?? ''?>"
               value="<?=$field['value'] ?? ''?>">
        <?php includeViewProvided($status == 'is-invalid', 'template.input.error', ['message' => $field['message'] ?? '']); ?>
    </div>
</div>