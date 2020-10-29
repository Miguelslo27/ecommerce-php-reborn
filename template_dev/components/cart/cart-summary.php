<aside class="cart-summary">
  <h2>resumen</h2>
  <?php
  $ordersubtotal = number_format(intval(getcurrentcart()->order->total) / 1.22, 2, ',', '');
  $ordertotal    = number_format(getcurrentcart()->order->total, 2, ',', '');
  ?>
  <hr>
  <div class="summary resume">
    <span class="label">subtotal</span>
    <span class="value">$ <?php bind($ordertotal) ?></span>
  </div>
  <hr>
  <div class="summary total">
    <span class="label">total</span>
    <span class="value">$ <?php bind($ordertotal) ?></span>
  </div>
  <div class="summary actions">
    <?php if (isloggedin()) : ?>
      <?php if (getglobal('sub_page') == 'payment') : ?>
        <a href="/" class="button primary">continuar</a>
        <hr>
        <a href="/carrito" class="button secondary">editar el carrito</a>
      <?php endif ?>
      <?php if (getglobal('sub_page') == 'shipping') : ?>
        <a href="/carrito/pagar" class="button primary disabled" id="shipping-button">continuar
        </a>
        <hr>
        <a href="/categorias" class="button secondary">seguir comprando</a>
      <?php endif ?>
      <?php if (getglobal('sub_page') == 'billing') : ?>
        <a href="/carrito/envio" class="button primary disabled" id="billing-button">continuar
        </a>
        <hr>
        <a href="/categorias" class="button secondary">seguir comprando</a>
      <?php endif ?>
      <?php if (getglobal('page') == 'cart' && getglobal('sub_page') == '') : ?>
        <a href="/carrito/datos-facturacion" class="button primary">pagar</a>
        <hr>
        <a href="/categorias" class="button secondary">seguir comprando</a>
      <?php endif ?>
    <?php else : ?>
      <a href="/login" class="button primary">ingresar</a>
      <hr>
      <a href="/registro" class="button secondary">registrarme</a>
    <?php endif ?>
  </div>
</aside>