<label for="<?=$name?>" class="text-primary <?=$addLabelClass ?? ''?>"><?=$label ?? 'label text'?></label><br>
<input type="<?=$type ?? 'text'?>" name="<?=$name?>" id="<?=$name?>"
       class="form-control rounded-0 <?=$addInputClass ?? ''?> <?=$status = $field['status'] ?? ''?>"
       value="<?=$field['value'] ?? ''?>" <?=$add ?? ''?>>
<?php includeViewProvided($status == 'is-invalid', 'template.input.error', ['message' => $field['message'] ?? '']); ?>
