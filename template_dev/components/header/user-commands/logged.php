<div class="user-links navigation">
  <div class="dropdown-nav">
    <a href="/cuenta/" class="access-menu normal-tab <?php isAdmin() ? bind('admin-item') : ''?>">
      <i class="fas fa-user-circle"></i>
      <span class="link-label"><?php echo getUserName() ?></span>
    </a>
    <div class="dropdown">
      <a href="/registro" class="access-menu dropdown-item">Edición</a>
      <?php if(isAdmin()) : ?>
        <a href="/admin" class="access-menu dropdown-item">Administrar</a>
      <?php endif ?>
      <a href="/?action=logout" class="access-menu normal-tab">
        <i class="fas fa-sign-out-alt"></i>
        <span class="link-label">Salir</span>
      </a>
    </div>
  </div>

  <?php if (!isAdmin()) : ?>
    <a href="/carrito" class="access-menu normal-tab">
      <i class="fas fa-shopping-cart"></i>
      <span class="access-menu normal-tab">Carrito: $<?php echo getCurrentCart() ? getCurrentCart()->order->total : 0 ?></span>
    </a>
  <?php endif ?>
</div>