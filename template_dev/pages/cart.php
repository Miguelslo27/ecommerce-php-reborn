<?php

newDocument([
  'title' => 'eCommerce - Mi Carrito',
  'page' => 'cart',
  'components' => [
    'components/header/header',
    'components/cart/cart',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/tables.css'
  ],
  'beforeRender' => function ()
  {
    setGlobal('featuredCategories', getCategories(null, 0, 4));
  }
]);
