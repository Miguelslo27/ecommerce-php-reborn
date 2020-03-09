<?php

newDocument([
  'title' => 'Proceso de pago',
  'page' => 'cart',
  'sub_page' => 'payment',
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
  'scripts' => [
    'components/forms/payment/payment.js'
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

    $phones = array();

    if (!empty(getCurrentUser()->phone)) {
      $phones[] = getCurrentUser()->phone;
    }

    if (!empty(getCurrentUser()->cellphone)) {
      $phones[] = getCurrentUser()->cellphone;
    }

    setGlobal('phones', $phones);
  }
]);
