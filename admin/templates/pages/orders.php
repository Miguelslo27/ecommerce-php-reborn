<?php

newDocument([
  'title' => 'eCommerce - Total Pedidos',
  'page' => 'admin',
  'sub_page' => 'total_orders',
  'components' => [
    'components/navbar',
    'components/searcher',
    'components/orders'
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
  }
]);