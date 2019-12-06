<?php $name = 'img_article'?>
<label for="<?=$name?>" class="text-primary"><?=$label ?? 'label text'?></label>
<input type="file" id="<?=$name?>" name="<?=$name?>"
       class="form-control-file <?=$status = $field['status'] ?? ''?>">
<?php includeViewProvided($status == 'is-invalid', 'template.input.error', ['message' => $field['message'] ?? '']); ?>