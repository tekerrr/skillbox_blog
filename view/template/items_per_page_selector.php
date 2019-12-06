<form class="ml-auto" method="post">
    <div class="btn-group">
        <label class="col-9 align-self-end" for="items">Количество на странице</label>
        <select class="form-control rounded-0 " name="items_per_page" id="items" onchange="form.submit()">
            <?php $options = ['10' => '10', '20' => '20', '50' => '50', '200' => '200', 'Все' => 'all']; ?>
            <?php foreach ($options as $key => $value): ?>
                <option value="<?=$value?>"  <?=$itemsPerPage == $value ? 'selected' : ''?>><?=$key?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="_method" value="PUT">
    </div>
</form>