<section class="full-inner form-register">
<?php if (empty(getCurrentCart()) || empty(getCurrentCart()->articles)) : ?>
  <h1 class="shadowed-title">
    <span class="title-shadow">Tu carrito está vacío</span>
    <span class="title">Tu carrito está vacío</span>
  </h1>
  <div class="cart-empty">
  <?php if (isLoggedIn()) : ?>
    <a href="/" class="button primary">Continuar comprando</a>
  <?php else : ?>
    <a href="/login/" class="button primary">Iniciar sesión</a>
    <a href="/" class="button secondary">Continuar comprando</a>
  <?php endif ?>
  </div>
<?php else : ?>
  <h1 class="shadowed-title">
    <span class="title-shadow">Carrito de compras</span>
    <span class="title">Carrito de compras</span>
  </h1>
  <div class="cart-details">
    <section class="cart-items">
      <div class="table">
        <div class="row headline">
          <span class="cell span-8">Articulo</span>
          <span class="cell span-2">P/U</span>
          <span class="cell span-2">Cant.</span>
          <span class="cell span-2">Subt.</span>
          <span class="cell span-2">Acciones</span>
        </div>
      <?php foreach (getCurrentCart()->articles as $article) : ?>
        <div class="row in-cart-article">
          <div class="cell article-info span-8">
            <div class="image">
              <img src="<?php bind($article->imagenes_url) ?>" alt="<?php bind($article->nombre) ?>">
            </div>
            <div class="title">
              <h3><?php bind($article->nombre) ?></h3>
              <span><?php bind($article->codigo) ?></span>
            </div>
          </div>
          <span class="cell article-price span-2">
            $ <?php bind($article->precio_actual) ?>
          </span>
          <span class="cell article-quantity span-2">
            <input type="number" id="_qty_for_<?php bind($article->articulo_id) ?>_" value="<?php bind($article->cantidad) ?>">
          </span>
          <span class="cell article-subtotal span-2">
            $ <?php bind($article->subtotal) ?>
          </span>
          <span class="cell article-actions span-2">
            <a href="#"
              class="update-cart-button"
              data-action="<?php bind(ACTION_ADD_TO_CART) ?>"
              data-oid="<?php bind(getCurrentCart()->order->id) ?>"
              data-aid="<?php bind($article->articulo_id) ?>"
              data-current-qty="<?php bind($article->cantidad) ?>"
              data-input-id="_qty_for_<?php bind($article->articulo_id) ?>_"
            ><i class="fas fa-sync"></i></a>
            <a href="#"><i class="far fa-trash-alt"></i></a>
          </span>
        </div>
      <?php endforeach ?>
      </div>
    </section>
    <aside class="cart-summary">
      <h2>Resumen</h2>
      <?php
        $orderSubTotal = number_format(intval(getCurrentCart()->order->total) / 1.22, 2, ',', '');
        $orderTaxes    = number_format((intval(getCurrentCart()->order->total) / 1.22) * 0.22, 2, ',', '');
        $orderTotal    = number_format(getCurrentCart()->order->total, 2, ',', '');
      ?>
      <hr>
      <div class="summary resume">
        <span class="label">Subtotal</span>
        <span class="value">$ <?php bind($orderSubTotal) ?></span>
        <span class="label">Impuestos</span>
        <span class="value">$ <?php bind($orderTaxes) ?></span>
      </div>
      <hr>
      <!-- <div class="summary discounts">
        <span class="label">Descuentos</span>
        <span class="value">$ 0,00</span>
      </div>
      <hr>
      <div class="summary shipping">
        <span class="label">Envío</span>
        <span class="value">$ 100,00</span>
      </div>
      <hr> -->
      <div class="summary total">
        <span class="label">Total</span>
        <span class="value">$ <?php bind($orderTotal) ?></span>
      </div>
      <div class="summary actions">
        <a href="#" class="button primary">Pagar</a>
      </div>
    </aside>
  </div>
<?php endif ?>
</section>