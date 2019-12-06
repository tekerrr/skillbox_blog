<div class="container mt-4">
    <div class="row justify-content-center">
        <?php foreach ($messages as $message): ?>
            <div class="alert alert-<?=$message->isError() ? 'danger' : 'success'?> alert-dismissible fade show w-75 rounded-0" role="alert">
                <strong><?=$message->getTitle()?></strong> <?=$message->getText()?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</div>