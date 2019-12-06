<label for="<?=$name?>" class="h4 <?=$addLabelClass ?? ''?>"><?=$label ?? 'label text'?></label>
<textarea class="form-control rounded-0 <?=$addInputClass ?? ''?> <?=$status = $field['status'] ?? ''?>"
          name="<?=$name?>" id="<?=$name?>" rows="<?=$rows ?? '3'?>"
          placeholder="Messege" onfocus="this.placeholder = ''"
          onblur="this.placeholder = 'Messege'"><?=$field['value'] ?? ''?></textarea>
<?php includeViewProvided($status == 'is-invalid', 'template.input.error', ['message' => $field['message'] ?? '']); ?>