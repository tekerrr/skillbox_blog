<?php

include VIEW_LAYOUT_DIR . (! empty($admin_header) ? 'admin_header.php' : 'header.php');

?>

<div class="container my-5">
    <div class="row justify-content-center my-3">
        <h1><?=$staticPage['title']?></h1>
    </div>
    <?=$staticPage['text']?>
</div>

<?php

include VIEW_LAYOUT_DIR . (! empty($admin_header) ? 'admin_footer.php' : 'footer.php');

?>