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
  <?php if (isLoggedIn()) : ?>
    <a href="/carrito/pagar" class="button primary">Pagar</a>
  <?php else : ?>
    <a href="/login" class="button primary">Ingresar</a>
    <hr>
    <a href="/registro" class="button secondary">Registrarme</a>
  <?php endif ?>
  </div>
</aside>