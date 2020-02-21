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
      header('Location: /');
    }

    $requestMessages = getGlobal('request_' . ACTION_LOGIN . '_messages');
    setSession('request_messages', $requestMessages);

    if (@$requestMessages->succeeded) {
      executeJavaScript('window.location.href = "/"');
    }

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

    setGlobal('classesHandler', $classesHandler);
    setGlobal('getPreFormData', $getPreFormData);
    setGlobal('request_messages', $requestMessages);
  }
]);
