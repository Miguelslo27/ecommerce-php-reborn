<?php

newDocument([
  'title' => 'eCommerce - Administrar Categorias',
  'page' => 'admin',
  'sub_page' => 'categories',
  'components' => [
    'components/navbar',
    'components/searcher',
    'components/categories'
  ],
  'styles' => [
    'components/css/fontawesome/css/all.min.css',
    'components/css/admin.css',
    'components/css/forms.css'
  ],
  'scripts' => [
    'components/admin.js'
  ],
  'beforeRender' => function ()
  {
    if (!isAdmin()) {
      header('Location: /');
      exit;
    }

    if (!isSuperAdmin()) {
      header('Location: /admin');
      exit;
    }

    $id = '';
    if (!empty(getQueryParamsByName(['cid']))) {
        $id = getQueryParamsByName(['cid'])['cid'];
    }
    
    /*
    //NETWORKS
    $facebook         = new stdClass();
    $facebook->title  = 'Facebook';
    $facebook->name   = 'facebook';
    $facebook->icon   = 'fa-facebook-square';
    $facebook->uri    = @getGlobal('uri_networks')->facebook;

    $instagram        = new stdClass();
    $instagram->title = 'Instagram';
    $instagram->name  = 'instagram';
    $instagram->icon  = 'fa-instagram-square';
    $instagram->uri   = @getGlobal('uri_networks')->instagram;

    $twitter          = new stdClass();
    $twitter->title   = 'Twitter';
    $twitter->name    = 'twitter';
    $twitter->icon    = 'fa-twitter';
    $twitter->uri     = @getGlobal('uri_networks')->twitter;

    $youtube          = new stdClass();
    $youtube->title   = 'Youtube';
    $youtube->name    = 'youtube';
    $youtube->icon    = 'fa-youtube';
    $youtube->uri     = @getGlobal('uri_networks')->youtube;

    $networks_object = [$facebook, $instagram, $twitter, $youtube];
    */
    //NAVBAR
    $users         = new stdClass();
    $users->title  = 'Usuarios';
    $users->number = '9745';
    $users->links  = [['Todos los usuarios', '/admin/usuarios?uid=todos'],['Usuarios suscriptos', '/admin/usuarios?uid=suscriptos'],['Nuevo usuario', '/admin/usuarios?uid=nuevo'],['Usuarios suspendidos', '/admin/usuarios?uid=suspendidos']];
    $users->icon   = 'fas fa-users';

    $categories         = new stdClass();
    $categories->title  = 'Categorías';
    $categories->number = '9';
    $categories->links  = [['Todos las categorías', '/admin/categorias/?cid=lista'],['Nueva categoría', '/admin/categorias?cid=nuevo'],['Categorías eliminadas', '/admin/categorias?cid=eliminadas']];
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
    setGlobal('section', $id);
  }
]);

function fieldHasError($field, $class)
{
  bind(
    !empty(getSession('request_messages'))
    && isset(getSession('request_messages')->fieldsWithErrors[$field])
    && getSession('request_messages')->fieldsWithErrors[$field]
      ? $class
      : ''
  );
}