<?php

newDocument([
  'title' => 'eCommerce - Administrador',
  'page' => 'admin-dashboard',
  'components' => [
    'components/admin/navbar',
    'components/admin/searcher',
    'components/admin/summary'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/admin.css'
  ],
  'scripts' => [
    'components/admin/admin.js'
  ],
  'beforeRender' => function ()
  {
    $users         = newStatusObject();
    $users->title  = 'Usuarios';
    $users->number = '9745';
    $users->links  = ['Todos los usuarios','Usuarios suscriptos','Nuevo usuario','Usuarios suspendidos'];
    $users->icon   = 'fas fa-users';

    $categories         = newStatusObject();
    $categories->title  = 'Categorías';
    $categories->number = '9';
    $categories->links  = ['Todos las categorías','Nueva categoría','Categorías eliminadas'];
    $categories->icon   = 'fas fa-th-large';

    $articles         = newStatusObject();
    $articles->title  = 'Artículos';
    $articles->number = '94';
    $articles->links  = ['Todos los artículos','Nuevo artículo','Artículos eliminados'];
    $articles->icon   = 'far fa-file';

    $orders         = newStatusObject();
    $orders->title  = 'Pedidos totales';
    $orders->number = '706';
    $orders->links  = ['Todos los pedidos','Pedidos pendientes','Pedidos abiertos','Pedidos cerrados','Pedidos cancelados'];
    $orders->icon   = 'fas fa-shopping-cart';

    $conf        = newStatusObject();
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