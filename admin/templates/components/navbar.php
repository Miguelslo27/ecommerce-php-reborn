<?php 
  $users         = new stdClass();
  $users->title  = 'Usuarios';
  $users->number = '9745';
  $users->links  = [['Todos los usuarios', '/admin/usuarios?uid=todos'],['Usuarios suscriptos', '/admin/usuarios?uid=suscriptos'],['Nuevo usuario', '/admin/usuarios?uid=nuevo'],['Usuarios suspendidos', '/admin/usuarios?uid=suspendidos']];
  $users->icon   = 'fas fa-users';
  $users->name   = 'users';

  $categories         = new stdClass();
  $categories->title  = 'Categorías';
  $categories->number = '9';
  $categories->links  = [['Todos las categorías', '/admin/categorias/?cid=lista'],['Nueva categoría', '/admin/categorias?cid=nueva'],['Categorías eliminadas', '/admin/categorias?cid=eliminadas']];
  $categories->icon   = 'fas fa-th-large';
  $categories->name   = 'categories';

  $articles         = new stdClass();
  $articles->title  = 'Artículos';
  $articles->number = '94';
  $articles->links  = [['Todos los artículos', '/admin/articulos/'],['Nuevo artículo', '/admin/articulos?aid=nuevo'],['Artículos eliminados', '/admin/articulos?aid=eliminados']];
  $articles->icon   = 'far fa-file';
  $articles->name   = 'articles';

  $orders         = new stdClass();
  $orders->title  = 'Pedidos totales';
  $orders->number = '706';
  $orders->links  = [['Todos los pedidos', '/admin/pedidos?pid=todos'],['Pedidos pendientes', '/admin/pedidos?pid=pendientes'],['Pedidos abiertos', '/admin/pedidos?pid=abiertos'],['Pedidos cerrados', '/admin/pedidos?pid=cerrados'],['Pedidos cancelados', '/admin/pedidos?pid=cancelados']];
  $orders->icon   = 'fas fa-shopping-cart';
  $orders->name   = 'orders';

  $conf        = new stdClass();
  $conf->title = 'Configuración';
  $conf->links = [['Datos de la tienda', '/admin/config?sid=datos'],['Información de contacto', '/admin/config?sid=contacto'],['Redes sociales', '/admin/config?sid=redes'],['Administradores', '/admin/config?sid=admins']];
  $conf->icon  = 'fas fa-cog';
  $conf->name  = 'conf';
?>

<div class="container-nav">
  <nav class="admin-nav">
    <div class="nav-items">
      <!-- USER ITEM -->
      <div class="user-link link item-user" data-open="false" data-type="user">
        <i class="fas fa-user-circle user"></i>
        <div class="arrow-right disabled"></div>
      </div>
      <!-- CATEGORIES ITEM -->
      <div class="link item-categories" data-open="false" data-type="categories">
        <i class="fas fa-th-large"></i>
        <div class="arrow-right disabled"></div>
      </div>
      <!-- ARTICLES ITEM -->
      <div class="link item-articles" data-open="false" data-type="articles">
        <i class="far fa-file"></i>
        <div class="arrow-right disabled"></div>
      </div>
      <!-- USERS ITEM -->
      <div class="link item-users" data-open="false" data-type="users">
        <i class="fas fa-users"></i>
        <div class="arrow-right disabled"></div>
      </div>
      <!-- ORDERS ITEM -->
      <div class="link item-orders" data-open="false" data-type="orders">
        <i class="fas fa-shopping-cart"></i>
        <div class="arrow-right disabled"></div>
      </div>
      <!-- CONFIGURATION ITEM -->
      <div class="link item-conf" data-open="false" data-type="conf">
        <i class="fas fa-cog"></i>
        <div class="arrow-right disabled"></div>
      </div>
    </div>
    <div class="notifications">
      <div class="link">
        <a href="/"><i class="fas fa-sign-in-alt"></i></a>
      </div>
    </div>
  </nav>
  <div class="nav-boxes">
    <!-- USER BOX -->
    <div class="user-box item-box hide-box" id="user">
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
    <!-- CATEGORIES BOX -->
    <?php setGlobal('actualItem', $categories) ?>
    <?php getTemplate('components/navbar-item') ?>
    <!-- ARTICLES BOX -->
    <?php setGlobal('actualItem', $articles) ?>
    <?php getTemplate('components/navbar-item') ?>
    <!-- USERS BOX -->
    <?php setGlobal('actualItem', $users) ?>
    <?php getTemplate('components/navbar-item') ?>
    <!-- ORDERS BOX -->
    <?php setGlobal('actualItem', $orders) ?>
    <?php getTemplate('components/navbar-item') ?>
    <!-- CONFIGURATION BOX -->
    <?php setGlobal('actualItem', $conf) ?>
    <?php getTemplate('components/navbar-item') ?>
  </div>
</div>