<?php

include ($preview ? VIEW_HEADER_ADMIN : VIEW_HEADER);

?>

<div class="container my-5">
    <div class="row justify-content-center my-3">
        <h1><?=$staticPage['title']?></h1>
    </div>
    <?=$staticPage['text']?>
</div>

<?php

include ($preview ? VIEW_FOOTER_ADMIN : VIEW_FOOTER);

?>