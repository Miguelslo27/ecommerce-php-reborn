<?php

newDocument([
  'title' => 'eCommerce - Administrar Articulos',
  'page' => 'admin',
  'sub_page' => 'articles',
  'components' => [
    'components/navbar',
    'components/searcher',
    'components/articles'
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