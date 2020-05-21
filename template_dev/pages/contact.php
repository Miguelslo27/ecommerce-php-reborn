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
    $categories            = getCategories();
    setGlobal('categories', oneOf($categories, []));
  },
]);