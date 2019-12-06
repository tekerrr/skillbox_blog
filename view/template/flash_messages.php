<?php if ($alertMessages = (new App\Controller\Session())->get('messages')): ?>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <?php foreach ($alertMessages as $alertMessage): ?>
                <div class="alert alert-<?=$alertMessage['error'] ? 'danger' : 'success'?> alert-dismissible fade show w-75 rounded-0" role="alert">
                    <strong><?=$alertMessage['title']?></strong> <?=$alertMessage['text']?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>