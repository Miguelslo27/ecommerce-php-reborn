<div class="user-links navigation">
  <div class="dropdown-nav">
    <a href="/cuenta" class="access-menu normal-tab">
      <i class="fas fa-user-circle"></i>
      <span class="link-label"><?php echo getUserName() ?></span>
    </a>
    <div class="dropdown">
      <a href="/registro?id=<?php echo getUserId() ?>" class="access-menu dropdown-item">Edición</a>
      <a href="/logout" class="access-menu normal-tab">
        <i class="fas fa-sign-out-alt"></i>
        <span class="link-label">Salir</span>
      </a>
    </div>
  </div>

  <?php if (isAdmin()) : ?>
    <a href="/admin/ordenes" class="access-menu normal-tab">Pedidos</a>
    <a href="/admin/usuarios" class="access-menu normal-tab">Usuarios</a>
  <?php endif ?>

  <?php if (!isAdmin()) : ?>
    <a href="/pedido" class="access-menu normal-tab">
      <i class="fas fa-shopping-cart"></i>
      <span class="access-menu normal-tab">Mi pedido: $<?php echo getCart()->total ?></span>
    </a>
  <?php endif ?>
</div>