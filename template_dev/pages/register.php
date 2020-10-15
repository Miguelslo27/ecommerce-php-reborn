<?php

newDocument([
  'title' => 'eCommerce - Registro',
  'page' => 'register',
  'components' => [
    'components/header/header',
    'components/forms/register',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css'
  ],
  'beforeRender' => function ()
  {
    $requestMessages = getSession('request_messages');

    if (@$requestMessages->succeeded && getCurrentUser()) {
      setSession('user', loadUser(getCurrentUser()->email));
    }

    if (@$requestMessages->succeeded && !getCurrentUser()) {
      header('Location: ' . (
        getSession('redirectTo') !== getServer('HTTP_ORIGIN') . getServer('REQUEST_URI')
        ? getSession('redirectTo')
        : '/'
      ));
      exit;
    }
    
    $categories = getCategories('`category_id` = 0 AND `status` = 1');

    setGlobal('categories', oneOf($categories, []));
    setSession('redirectTo', oneOf(@$_SERVER['HTTP_REFERER'], '/'));

    $classesHandler = function ($field, $class)
    {
      bind(
        !empty(getSession('request_messages'))
        && isset(getSession('request_messages')->fieldsWithErrors[$field])
        && getSession('request_messages')->fieldsWithErrors[$field]
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

      if (getCurrentUser()) {
        bind(getCurrentUser()->{$data});
        return;
      }
    };

    setGlobal('classesHandler', $classesHandler);
    setGlobal('getPreFormData', $getPreFormData);
  }
]);
