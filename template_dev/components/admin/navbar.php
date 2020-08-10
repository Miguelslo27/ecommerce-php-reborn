<div class="container-nav">
  <nav class="admin-nav">
    <div class="nav-items">
      <a href="#" class="user-link link item-user" data-open="false" data-type="user">
        <i class="fas fa-user-circle user"></i>
        <div class="arrow-right disabled"></div>
      </a>
      <!-- USER ITEM -->
      <div class="user-box item-box disabled" id="user">
        <div class="close-container">
          <i class="fas fa-times close-box" data-close-type="user"></i>
        </div>
        <div class="picture">
          <i class="fas fa-user-circle user"></i>
        </div>
        <h3>User Name</h3>
        <div class="item-sub-links">
          <i class="fas fa-envelope"></i>
          <i class="fas fa-bell"></i>
        </div>
        <ul>
          <li>Editar datos de usuario</li>
          <li>Correo nuevo</li>
          <li>Cuenta</li>
        </ul>
      </div>
      <!-- CATEGORIES ITEM -->
      <a href="#" class="link item-categories" data-open="false" data-type="categories">
        <i class="fas fa-th-large"></i>
        <div class="arrow-right disabled"></div>
      </a>
      <?php setGlobal('actualItem', 'categories') ?>
      <?php getTemplate('components/admin/navbar-item') ?>
      <!-- ARTICLES ITEM -->
      <a href="#" class="link item-articles" data-open="false" data-type="articles">
        <i class="far fa-file"></i>
        <div class="arrow-right disabled"></div>
      </a>
      <?php setGlobal('actualItem', 'articles') ?>
      <?php getTemplate('components/admin/navbar-item') ?>
      <!-- USERS ITEM -->
      <a href="#" class="link item-users" data-open="false" data-type="users">
        <i class="fas fa-users"></i>
        <div class="arrow-right disabled"></div>
      </a>
      <?php setGlobal('actualItem', 'users') ?>
      <?php getTemplate('components/admin/navbar-item') ?>
      <!-- ORDERS ITEM -->
      <a href="#" class="link item-orders" data-open="false" data-type="orders">
        <i class="fas fa-shopping-cart"></i>
        <div class="arrow-right disabled"></div>
      </a>
      <?php setGlobal('actualItem', 'orders') ?>
      <?php getTemplate('components/admin/navbar-item') ?>
      <!-- CONFIGURATION ITEM -->
      <a href="#" class="link item-conf" data-open="false" data-type="conf">
        <i class="fas fa-cog"></i>
        <div class="arrow-right disabled"></div>
      </a>
      <?php setGlobal('actualItem', 'conf') ?>
      <?php getTemplate('components/admin/navbar-item') ?>
    </div>
    <div class="notifications">
      <a href="#" class="" >
        <i class="far fa-bell"></i>
      </a>
    </div>
  </nav>
</div>    