<?php if (isset($errorAlerts)): ?>
    <?php foreach ($errorAlerts as $alert): ?>
        <div class="alert alert-danger row" role="alert">
            <?=$alert?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>