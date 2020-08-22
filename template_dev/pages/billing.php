<?php

newDocument([
  'title' => 'Datos de facturación',
  'page' => 'cart',
  'sub_page' => 'billing',
  'components' => [
    'components/header/header',
    'components/cart/billing',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css',
    'components/cart/payment.css',
    'components/cart/cart-summary.css'
  ],
  'beforeRender' => beforeRender()
]);

function beforeRender()
{
  return function ()
  {
    $categories = getCategories();
    setGlobal('categories', oneOf($categories, []));
  };
}
