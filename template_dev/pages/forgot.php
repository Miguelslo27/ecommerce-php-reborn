<?php

newDocument([
  'title' => 'eCommerce - Contraseña perdida',
  'page' => 'forgot',
  'components' => [
    'components/header/header',
    'components/forms/forgot/forgot',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css',
    'components/forms/login/login.css'
  ],
  'beforeRender' => function ()
  {
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

    $categories = getCategories();

    setGlobal('request_messages', getSession('request_messages'));
    setGlobal('classesHandler', $classesHandler);
    setGlobal('categories', oneOf($categories, []));
  }
]);
