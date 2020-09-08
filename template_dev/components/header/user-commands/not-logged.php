<div class="user-links navigation">
  <a href="/login" class="access-menu normal-tab">
    <i class="far fa-user-circle"></i>
    <span>Ingresar</span>
  </a>
  <a href="/registro" class="access-menu normal-tab">
    <i class="fas fa-user-plus"></i>
    <span>Registrarme</span>
  </a>
  <a href="/carrito" class="access-menu normal-tab">
    <i class="fas fa-shopping-cart"></i>
    <span class="access-menu normal-tab">Carrito: $<?php echo getCurrentCart() ? getCurrentCart()->order->total : 0 ?></span>
  </a>
</div>