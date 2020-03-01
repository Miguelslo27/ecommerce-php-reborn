<section class="full-inner form-register">
  <?php if (empty(getCurrentCart())) : ?>
  <h1 class="shadowed-title">
    <span class="title-shadow">Tu carrito está vacío</span>
    <span class="title">Tu carrito está vacío</span>
  </h1>
  <div class="cart-empty">
    <a href="/login/" class="button primary">Iniciar sesión</a>
    <a href="/" class="button secondary">Continuar comprando</a>
  </div>
  <?php getTemplate('components/lists/categories/featured-categories') ?>
  <?php else : ?>
  <h1 class="shadowed-title">
    <span class="title-shadow">Carrito de compras</span>
    <span class="title">Carrito de compras</span>
  </h1>
  <div class="cart-details">
    <section class="cart-items">
      <div class="table">
        <div class="row headline">
          <span class="cell span-5">Articulo</span>
          <span class="cell span-2">P/U</span>
          <span class="cell span-2">Cant.</span>
          <span class="cell span-2">Subt.</span>
          <span class="cell">Acciones</span>
        </div>
      </div>
    </section>
    <aside class="cart-summary">
      <h2>Summary</h2>
    </aside>
  </div>
  <?php endif ?>
</section>