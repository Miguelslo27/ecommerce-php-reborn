<?php if( strlen(getGlobal('category')->title) < 13) :?>
    <a href="/categoria/?cid=<?php bind(getGlobal('category')->id) ?>" class="access-menu dropdown-item"><?php bind(getGlobal('category')->title) ?></a>
<?php else : ?>
    <a href="/categoria/?cid=<?php bind(getGlobal('category')->id) ?>" class="access-menu dropdown-item"><?php bind(explode(' ',trim(getGlobal('category')->title))[0]) ?></a>
<?php endif ?>