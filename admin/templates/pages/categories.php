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

    $action = null;
    $id     = null;
    $cid    = null;

    if (!empty(getQueryParamsByName(['action']))) {
      $action = getQueryParamsByName(['action'])['action'];
    }

    if (!empty(getQueryParamsByName(['id']))) {
      $id = getQueryParamsByName(['id'])['id'];
    }

    if (!empty(getQueryParamsByName(['cid']))) {
      $cid = getQueryParamsByName(['cid'])['cid'];
    }

    $categorySuccess = false;
    !empty(getSession('request_messages')) ? $categorySuccess = getSession('request_messages')->succeeded : "";

    setGlobal('section', $cid);
    setGlobal('action', $action);
    setGlobal('id', $id);
    setGlobal('category_success', $categorySuccess);
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