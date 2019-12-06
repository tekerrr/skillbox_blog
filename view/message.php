<?php

include VIEW_LAYOUT_DIR . (! empty($admin_header) ? 'admin_header.php' : 'header.php');

?>

<div class="container">
    <h2 class="text-center pt-5"><?=$header?? 'Отлично!'?></h2>
    <h4 class="text-center"><?=$message?? 'текст сообщения'?></h4>

    <div class="row justify-content-center align-items-center">
        <a class="h4" href="?<?=$path ?? PATH_DEFAULT?>"><?=$pathName ?? 'На главную'?></a>
    </div>
</div>

<?php

include VIEW_LAYOUT_DIR . (! empty($admin_header) ? 'admin_footer.php' : 'footer.php');

?>
