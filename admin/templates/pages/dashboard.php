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
    if (!isAdmin()) {
      header('Location: /');
      exit;
    }
  }
]);