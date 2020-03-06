<?php

newDocument([
  'components' => [
    'components/header/header',
    'components/payment/payment',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css',
    'components/forms/payment/payment.css',
    'components/cart-summary/cart-summary.css'
  ],
  'beforeRender' => function ()
  {
    if (!isLoggedIn()) {
      header('Location: /login');
      exit;
    }
    if (!getCurrentCart() || count(getCurrentCart()->articles) == 0) {
      header('Location: /carrito');
      exit;
    }
  }
]);
