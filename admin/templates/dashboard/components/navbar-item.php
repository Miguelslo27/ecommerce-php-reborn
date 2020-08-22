<?php
  $actualItem = getGlobal('actualItem');
  $item = getGlobal($actualItem);
?>

<div class="item-box disabled" id="<?php bind($actualItem)?>">
  <div class="close-container">
    <i class="fas fa-times close-box" data-close-type="<?php bind($actualItem)?>"></i>
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
    <li><?php bind($link)?></li>
    <?php endforeach ?>
  </ul>
</div>