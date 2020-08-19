<?php

newDocument([
  'title' => 'eCommerce - Administrador',
  'page' => 'admin',
  'sub_page' => 'dashboard',
  'components' => [
    'components/navbar',
    'components/searcher',
    'components/summary'
  ],
  'styles' => [
    'components/css/fontawesome/css/all.min.css',
    'components/css/admin.css'
  ],
  'scripts' => [
    'components/admin.js'
  ],
  'beforeRender' => function ()
  {
    $users         = new stdClass();
    $users->title  = 'Usuarios';
    $users->number = '9745';
    $users->links  = ['Todos los usuarios','Usuarios suscriptos','Nuevo usuario','Usuarios suspendidos'];
    $users->icon   = 'fas fa-users';

    $categories         = new stdClass();
    $categories->title  = 'Categorías';
    $categories->number = '9';
    $categories->links  = ['Todos las categorías','Nueva categoría','Categorías eliminadas'];
    $categories->icon   = 'fas fa-th-large';

    $articles         = new stdClass();
    $articles->title  = 'Artículos';
    $articles->number = '94';
    $articles->links  = ['Todos los artículos','Nuevo artículo','Artículos eliminados'];
    $articles->icon   = 'far fa-file';

    $orders         = new stdClass();
    $orders->title  = 'Pedidos totales';
    $orders->number = '706';
    $orders->links  = ['Todos los pedidos','Pedidos pendientes','Pedidos abiertos','Pedidos cerrados','Pedidos cancelados'];
    $orders->icon   = 'fas fa-shopping-cart';

    $conf        = new stdClass();
    $conf->title = 'Configuración';
    $conf->links = ['Datos de la tienda','Información de contacto','Redes sociales','Administradores'];
    $conf->icon  = 'fas fa-cog';

    setGlobal('users', $users);
    setGlobal('categories', $categories);
    setGlobal('articles', $articles);
    setGlobal('orders', $orders);
    setGlobal('conf', $conf);
  }
]);