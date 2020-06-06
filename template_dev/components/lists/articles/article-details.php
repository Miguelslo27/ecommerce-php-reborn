<?php
$class = '';
$dscp = '';
$discount = '';

if (getGlobal('currentArticle')->new === '1') {
  $class = 'new';
}

if (getGlobal('currentArticle')->offer === '1') {
  $class = 'offer';
  $discount = 100 - (((getGlobal('currentArticle')->price_offer) * 100) / (getGlobal('currentArticle')->price));
}

if (getGlobal('currentArticle')->spent === '1') {
  $class = 'spent';
}
if (getGlobal('currentArticle')->description === '') {
  $dscp = 'not-dscp';
}
?>
<article class="details <?php bind($dscp) ?>">
  <div class="img-container">
    <img src="<?php bind(getGlobal('currentArticle')->images_url) ?>" alt="<?php bind(getGlobal('currentArticle')->name) ?>">
  </div>
  <div class="article-info <?php bind($class) ?>">
    <!--  ARTICLE PATH   -->
    <div class="article-path">
      <a href="/">Inicio / </a>
      <?php if (getGlobal('mainCategory')) : ?>
        <a href="/"><?php bind(getGlobal('mainCategory')->title)?> / </a>
      <?php endif ?>
      <a href="/"><?php bind(getGlobal('currentCategory')->title)?></a>
    </div>
    <!--  TITLE   -->
    <h4><?php bind(getGlobal('currentArticle')->name) ?></h4>
    <!--  CODE   -->
    <span class="code">Cod. <?php bind(getGlobal('currentArticle')->code) ?></span>
    <!--  PRICE   -->
    <?php if (getGlobal('currentArticle')->offer === '1') : ?>
      <div class="price-container">
        <span class="price before">$<?php bind(getGlobal('currentArticle')->price) ?></span>
        <div class="price-discount">
          <span class="price after">$<?php bind(getGlobal('currentArticle')->price_offer) ?></span>
          <p><?php bind(round($discount)) ?> % OFF</p>
        </div>
      </div>
    <?php else : ?>
      <span class="price">$<?php bind(getGlobal('currentArticle')->price) ?></span>
    <?php endif ?>
    <!--  STOCK   -->
    <?php if ($class != 'spent') : ?>
      <p class="stock">Stock Disponible</p>
    <?php else : ?>
      <p class="stock">No hay stock</p>
    <?php endif ?>
    <hr>
    <?php if ($class != 'spent') : ?>
      <div class="cart-actions">
        <form method="GET">
          <input name="qty" id="quantity" type="number" min="1" max="99" required value="1">
          <input type="hidden" name="action" value="<?php bind(ACTION_ADD_TO_CART) ?>" />
          <input type="hidden" name="aid" value="<?php bind(getGlobal('currentArticle')->id) ?>" />
          <button type="submit" class="search-button"><i class="fas fa-shopping-cart"></i>Agregar al carrito</button>
        </form>
      </div>
    <?php endif ?>
    <!--  DSCP LINK   -->
    <?php if (getGlobal('currentArticle')->description) : ?>
      <a class="link-description" href="#description">>> Ver descripción <<</a>
    <?php endif ?>
    <!--  ADMIN OPTIONS   -->
    <?php if (isAdmin()) : ?>
      <div class="admin-article-controls">
        <a href="/articulo/editar/?aid=<?php bind(getGlobal('currentArticle')->id) ?>"><i class="far fa-edit"></i></a>
        <a href="/articulo/eliminar/?aid=<?php bind(getGlobal('currentArticle')->id) ?>"><i class="far fa-trash-alt"></i></a>
      </div>
    <?php endif ?>
  </div>
</article>
<?php if (getGlobal('currentArticle')->description) : ?>
  <div class="article-description" id="description">
    <p class="subtitle">Descripción:</p>
    <hr>
    <p><?php bind(getGlobal('currentArticle')->description) ?></p>
  </div>
<?php endif ?>
