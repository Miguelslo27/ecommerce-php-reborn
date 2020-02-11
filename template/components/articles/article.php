<?php
$class = '';
if ($article->nuevo === '1') {
$class = 'new';
}

if ($article->oferta === '1') {
$class = 'offer';
}

if ($article->agotado === '1') {
$class = 'spent';
}
?>
<article class="<?php echo $class ?>">
  <img src="<?php echo $article->imagenes_url ?>" alt="<?php echo $article->nombre ?>">
  <div class="article-info">
    <span><?php echo $article->descripcion_breve ?></span>
    <a href="<?php echo $article->id ?>"><?php echo $article->nombre ?></a>

    <?php if ($article->oferta === '1') : ?>
      <span class="price before">$<?php echo $article->precio ?></span>
      <span class="price after">$<?php echo $article->precio_oferta ?></span>
    <?php else : ?>
      <span class="price">$<?php echo $article->precio ?></span>
    <?php endif ?>
  </div>
  <hr>
  <div class="actions">
    <a href="?<?php echo getQueryParams(['addtocart' => $article->id]) ?>">Agregar al carrito +</a>
  </div>

  <?php if (isAdmin()) : ?>
    <div class="admin-article-controls">
      <a href="/producto/editar/?cid=<?php echo $article->id ?>"><i class="far fa-edit"></i></a>
      <a href="/producto/eliminar/?cid=<?php echo $article->id ?>"><i class="far fa-trash-alt"></i></a>
    </div>
  <?php endif ?>
</article>