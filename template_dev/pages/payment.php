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

    $billingInfo         = getOrderBillingInfo(getCurrentCart()->order->id);
    $billingDocument     = oneOf($billingInfo->billing_document, getCurrentUser()->document);
    $billingAddress      = oneOf($billingInfo->billing_address, getCurrentUser()->address);
    $billingState        = oneOf($billingInfo->billing_state, getCurrentUser()->state);
    $billingCity         = oneOf($billingInfo->billing_city, getCurrentUser()->city);
    $billingZipcode      = oneOf($billingInfo->billing_zipcode, '');
    $billingFullAddress  = array();
    $phones              = array();

    if (!empty(getCurrentUser()->phone)) {
      $phones[] = '<a href="tel:' . getCurrentUser()->phone . '">' . getCurrentUser()->phone . '</a>';
    }

    if (!empty(getCurrentUser()->cellphone)) {
      $phones[] = '<a href="tel:' . getCurrentUser()->cellphone . '">' . getCurrentUser()->cellphone . '</a>';
    }

    if (!empty(oneOf($billingInfo->billing_address, getCurrentUser()->address))) {
      $billingFullAddress[] = oneOf($billingInfo->billing_address, getCurrentUser()->address);
    }

    if (!empty(oneOf($billingInfo->billing_state, getCurrentUser()->state))) {
      $billingFullAddress[] = oneOf($billingInfo->billing_state, getCurrentUser()->state);
    }

    if (!empty(oneOf($billingInfo->billing_city, getCurrentUser()->city))) {
      $billingFullAddress[] = oneOf($billingInfo->billing_city, getCurrentUser()->city);
    }

    if (!empty($billingInfo->billing_zipcode)) {
      $billingFullAddress[] = $billingInfo->billing_zipcode;
    }

    setGlobal('billing_name', oneOf($billingInfo->billing_name, getCurrentUser()->name . ' ' . getCurrentUser()->lastname));
    setGlobal('billing_document', $billingDocument);
    setGlobal('billing_fulladdress', implode(', ', $billingFullAddress));
    setGlobal('billing_address', $billingAddress);
    setGlobal('billing_state', $billingState);
    setGlobal('billing_city', $billingCity);
    setGlobal('billing_zipcode', $billingZipcode);
    setGlobal('phones', implode(' / ', $phones));
  }
]);
