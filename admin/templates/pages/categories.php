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