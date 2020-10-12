<?php
$class = '';
if (getGlobal('article')->new === '1') {
  $class = 'new';
}

if (getGlobal('article')->offer === '1') {
  $class = 'offer';
}

if (getGlobal('article')->spent === '1') {
  $class = 'spent';
}
?>
<article class="<?php bind($class) ?>">
  <img src="<?php bind(getGlobal('article')->images_url) ?>" alt="<?php bind(getGlobal('article')->name) ?>">
  <div class="article-info">
    <a href="/articulo/?aid=<?php bind(getGlobal('article')->id) ?>"><?php bind(getGlobal('article')->name) ?></a>
    <?php if (getGlobal('article')->offer === '1') : ?>
      <span class="price before">$<?php bind(getGlobal('article')->price) ?></span>
      <span class="price after">$<?php bind(getGlobal('article')->price_offer) ?></span>
    <?php else : ?>
      <span class="price">$<?php bind(getGlobal('article')->price) ?></span>
    <?php endif ?>
    
  </div>
  <hr>
  <div class="actions">
    <a href="<?php if (getGlobal('articleURI')) : ?>/<?php endif ?>?<?php bind(getQueryParams(['action' => ACTION_ADD_TO_CART, 'aid' => getGlobal('article')->id])) ?>">Agregar al carrito +</a>
  </div>
</article>