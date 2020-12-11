<?php

newDocument([
  'title' => 'eCommerce - Administrar Articulos',
  'page' => 'admin',
  'sub_page' => 'articles',
  'components' => [
    'components/navbar',
    'components/searcher'
  ],
  'styles' => [
    'components/css/fontawesome/css/all.min.css',
    'components/css/admin.css',
    'components/css/forms.css'
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