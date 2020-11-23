<?php

newDocument([
  'title' => 'eCommerce - Administrar Articulos',
  'page' => 'admin',
  'sub_page' => 'categories',
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

    $action = null;
    $id     = null;
    $aid    = null;

    if (!empty(getQueryParamsByName(['action']))) {
      $action = getQueryParamsByName(['action'])['action'];
    }

    if (!empty(getQueryParamsByName(['id']))) {
      $id = getQueryParamsByName(['id'])['id'];
    }

    if (!empty(getQueryParamsByName(['aid']))) {
      $aid = getQueryParamsByName(['aid'])['aid'];
    }

    setGlobal('section', $aid);
    setGlobal('action', $action);
    setGlobal('id', $id);
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