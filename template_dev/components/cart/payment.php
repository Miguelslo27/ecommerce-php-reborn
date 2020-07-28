<section class="full-inner">
  <h1 class="shadowed-title">
    <span class="title-shadow">Completar datos de envío y pago</span>
    <span class="title">Completar datos de envío y pago</span>
  </h1>
  <<div class="payment-content">
    <section class="payment-form">
      <?php getTemplate('components/forms/payment/payment-info') ?>
    </section>
    <?php getTemplate('components/cart/cart-summary') ?>
  </div>
  <p><?php bind(printMessage())?></p>
</section>