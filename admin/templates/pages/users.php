<?php

newDocument([
  'title' => 'eCommerce - Administrar Usuarios',
  'page' => 'admin',
  'sub_page' => 'users',
  'components' => [
    'components/navbar',
    'components/searcher',
    'components/users'
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
