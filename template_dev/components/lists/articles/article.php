<?php
$class = '';
if (getGlobal('article')->nuevo === '1') {
  $class = 'new';
}

if (getGlobal('article')->oferta === '1') {
  $class = 'offer';
}

if (getGlobal('article')->agotado === '1') {
  $class = 'spent';
}
?>
<article class="<?php bind($class) ?>">
  <img src="<?php bind(getGlobal('article')->imagenes_url) ?>" alt="<?php bind(getGlobal('article')->nombre) ?>">
  <div class="article-info">
    <span><?php bind(getGlobal('article')->descripcion_breve) ?></span>
    <a href="<?php bind(getGlobal('article')->id) ?>"><?php bind(getGlobal('article')->nombre) ?></a>

    <?php if (getGlobal('article')->oferta === '1') : ?>
      <span class="price before">$<?php bind(getGlobal('article')->precio) ?></span>
      <span class="price after">$<?php bind(getGlobal('article')->precio_oferta) ?></span>
    <?php else : ?>
      <span class="price">$<?php bind(getGlobal('article')->precio) ?></span>
    <?php endif ?>
    
  </div>
  <hr>
  <div class="actions">
    <a href="?<?php bind(getQueryParams(['action' => ACTION_ADD_TO_CART, 'aid' => getGlobal('article')->id])) ?>">Agregar al carrito +</a>
  </div>

  <?php if (isAdmin()) : ?>
    <div class="admin-article-controls">
      <a href="/articulo/editar/?aid=<?php bind(getGlobal('article')->id) ?>"><i class="far fa-edit"></i></a>
      <a href="/articulo/eliminar/?aid=<?php bind(getGlobal('article')->id) ?>"><i class="far fa-trash-alt"></i></a>
    </div>
  <?php endif ?>
</article>