<?php

newDocument([
  'title' => 'eCommerce - Ingresar',
  'page' => 'login',
  'components' => [
    'components/header/header',
    'components/forms/login/login',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css'
  ],
  'beforeRender' => function ()
  {
    if (isLoggedIn()) {
      header('Location: ' . (
        getSession('redirectTo') !== getServer('HTTP_ORIGIN') . getServer('REQUEST_URI')
        ? (isAdmin() ? '/admin' : getSession('redirectTo'))
        : (isAdmin() ? '/admin' : '/')
      ));
      exit;
    }

    setSession('redirectTo', oneOf(@$_SERVER['HTTP_REFERER'], '/'));

    $classesHandler = function ($field, $class)
    {
      bind(
        !empty(getGlobal('request_messages'))
        && isset(getGlobal('request_messages')->fieldsWithErrors[$field])
        && getGlobal('request_messages')->fieldsWithErrors[$field]
          ? $class
          : ''
      );
    };

    $getPreFormData = function ($data)
    {
      if (getPostData($data)) {
        bind(getPostData($data));
        return;
      }
    };

    $categories = getCategories('`category_id` = 0 AND `status` = 1');

    setGlobal('categories', oneOf($categories, []));
    setGlobal('classesHandler', $classesHandler);
    setGlobal('getPreFormData', $getPreFormData);
    setGlobal('request_messages', getSession('request_messages'));
  }
]);
