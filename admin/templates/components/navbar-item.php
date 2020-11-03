<?php
  $item = getGlobal('actualItem');
  $uri = getRequestURIPath();
?>

<div class="item-box disabled" id="<?php bind($item->name)?>">
  <div class="close-container">
    <i class="fas fa-times close-box" data-close-type="<?php bind($item->name)?>"></i>
  </div>
  <div class="item-icon">
    <i class="<?php bind($item->icon) ?>"></i>
  </div>
  <?php if (isset($item->number)) : ?>
    <h3 class="item-number"><?php bind($item->number) ?></h3>
  <?php endif ?>  
  <h3 class="item-title"><?php bind($item->title) ?></h3>
  <ul>
    <?php foreach ($item->links as $link) : ?>
    <a href="<?php bind($link[1]) ?>"><li><?php bind($link[0])?></li></a>
    <?php endforeach ?>
  </ul>
</div>