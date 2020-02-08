<div class="user-links navigation">
  <div class="dropdown-nav">
    <a href="/cuenta" class="access-menu normal-tab">
      <i class="fas fa-user-circle"></i>
      <span class="link-label"><?php echo $userName ?></span>
    </a>
    <div class="dropdown">
      <a href="/registro?id=<?php echo $userStats['user']->id ?>" class="access-menu dropdown-item">Edición</a>
      <a href="/logout" class="access-menu normal-tab">
        <i class="fas fa-sign-out-alt"></i>
        <span class="link-label">Salir</span>
      </a>
    </div>
  </div>
  <?php if (@$userStats['user']->administrador == 1) : ?>
    <a href="/administrar-pedidos" class="access-menu normal-tab">Pedidos</a>
    <a href="/administrar-usuarios" class="access-menu normal-tab">Usuarios</a>
  <?php endif ?>
  <?php if (@$userStats['user']->administrador == 0) : ?>
    <a href="/pedido" class="access-menu normal-tab">
      <i class="fas fa-shopping-cart"></i>
      <span class="access-menu normal-tab">Mi pedido: $<?php echo $userStats['cart'] ? $userStats['cart']->cantidad : 0; ?></span>
    </a>
  <?php endif ?>
</div>