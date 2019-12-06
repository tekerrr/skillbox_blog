<form class="ml-auto" method="post">
    <div class="btn-group">
        <label class="col-9 align-self-end" for="items">Количество на странице</label>
        <select class="form-control rounded-0 " name="items_per_page" id="items" onchange="form.submit()">
            <option value="10"  <?=$paginatorItemsPerPage == '10' ? 'selected' : ''?>>10</option>
            <option value="20"  <?=$paginatorItemsPerPage == '20' ? 'selected' : ''?>>20</option>
            <option value="50"  <?=$paginatorItemsPerPage == '50' ? 'selected' : ''?>>50</option>
            <option value="200" <?=$paginatorItemsPerPage == '200' ? 'selected' : ''?>>200</option>
            <option value="all" <?=$paginatorItemsPerPage == 'all' ? 'selected' : ''?>>Все</option>
        </select>
        <input type="hidden" name="_method" value="PUT">
    </div>
</form>