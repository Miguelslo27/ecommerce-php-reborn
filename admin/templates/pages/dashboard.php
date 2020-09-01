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
    $users->links  = [['Todos los usuarios', '/admin/usuarios?uid=todos'],['Usuarios suscriptos', '/admin/usuarios?uid=suscriptos'],['Nuevo usuario', '/admin/usuarios?uid=nuevo'],['Usuarios suspendidos', '/admin/usuarios?uid=suspendidos']];
    $users->icon   = 'fas fa-users';

    $categories         = new stdClass();
    $categories->title  = 'Categorías';
    $categories->number = '9';
    $categories->links  = [['Todos las categorías', '/admin/categorias?cid=todos'],['Nueva categoría', '/admin/categorias?cid=nuevo'],['Categorías eliminadas', '/admin/categorias?cid=eliminadas']];
    $categories->icon   = 'fas fa-th-large';

    $articles         = new stdClass();
    $articles->title  = 'Artículos';
    $articles->number = '94';
    $articles->links  = [['Todos los artículos', '/admin/articulos?aid=todos'],['Nuevo artículo', '/admin/articulos?aid=nuevo'],['Artículos eliminados', '/admin/articulos?aid=eliminados']];
    $articles->icon   = 'far fa-file';

    $orders         = new stdClass();
    $orders->title  = 'Pedidos totales';
    $orders->number = '706';
    $orders->links  = [['Todos los pedidos', '/admin/pedidos?pid=todos'],['Pedidos pendientes', '/admin/pedidos?pid=pendientes'],['Pedidos abiertos', '/admin/pedidos?pid=abiertos'],['Pedidos cerrados', '/admin/pedidos?pid=cerrados'],['Pedidos cancelados', '/admin/pedidos?pid=cancelados']];
    $orders->icon   = 'fas fa-shopping-cart';

    $conf        = new stdClass();
    $conf->title = 'Configuración';
    $conf->links = [['Datos de la tienda', '/admin/config?sid=datos'],['Información de contacto', '/admin/config?sid=contacto'],['Redes sociales', '/admin/config?sid=redes'],['Administradores', '/admin/config?sid=admins']];
    $conf->icon  = 'fas fa-cog';

    setGlobal('users', $users);
    setGlobal('categories', $categories);
    setGlobal('articles', $articles);
    setGlobal('orders', $orders);
    setGlobal('conf', $conf);
  }
]);