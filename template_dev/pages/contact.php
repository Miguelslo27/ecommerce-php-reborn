<?php

newDocument([
  'title' => 'eCommerce - Contacto',
  'page' => 'contact',
  'components' => [
    'components/header/header',
    'components/contact-content/contact-content',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css'
  ],

  'beforeRender' => function ()
  {
    $classesHandler = function ($field, $class)
    {
      bind(
        !empty(getSession('request_messages'))
        && isset(getSession('request_messages')->fieldsWithErrors[$field])
          ? $class
          : ''
      );
    };

    $categories            = getCategories();
    setGlobal('categories', oneOf($categories, []));
    setGlobal('classesHandler', $classesHandler);
  }
]);