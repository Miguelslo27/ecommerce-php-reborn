<?php

newDocument([
  'title' => 'eCommerce - Datos de envío',
  'page' => 'cart',
  'sub_page' => 'shipping',
  'components' => [
    'components/header/header',
    'components/cart/shipping',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css',
    'components/cart/payment.css',
    'components/cart/cart-summary.css'
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

    $shippingInfo        = getOrderShippingInfo(getCurrentCart()->order->id);
    $shippingAddress     = $shippingInfo->shipping_address;
    $shippingState       = $shippingInfo->shipping_state;
    $shippingCity        = $shippingInfo->shipping_city;
    $shippingAgency      = $shippingInfo->shipping_agency;
    $shippingZipcode     = $shippingInfo->shipping_zipcode;
    $shippingComments    = $shippingInfo->additional_comments;
    $shippingFullAddress = array();

    if (!empty($shippingAddress)) {
      $shippingFullAddress[] = $shippingAddress;
    }

    if (!empty($shippingState)) {
      $shippingFullAddress[] = $shippingState;
    }

    if (!empty($shippingCity)) {
      $shippingFullAddress[] = $shippingCity;
    }

    if (!empty($shippingZipcode)) {
      $shippingFullAddress[] = $shippingZipcode;
    }

    $categories = getCategories();

    setGlobal('canUseBilling', canUseBilling());
    setGlobal('categories', oneOf($categories, []));
    setGlobal('shipping_method', $shippingInfo->shipping_method);
    setGlobal('shippingAddress', $shippingAddress);
    setGlobal('shippingState', $shippingState);
    setGlobal('shippingCity', $shippingCity);
    setGlobal('shippingAgency', $shippingAgency);
    setGlobal('shippingZipcode', $shippingZipcode);
    setGlobal('shippingComments', $shippingComments);
    setGlobal('shipping_fulladdress', implode(', ', $shippingFullAddress));
  }
]);

function shippingInfoFormHasErrors()
{
  if (!empty(getSession('request_messages'))) {
    if (
      @getSession('request_messages')->fieldsWithErrors['shipping_address']
      || @getSession('request_messages')->fieldsWithErrors['shipping_state']
      || @getSession('request_messages')->fieldsWithErrors['shipping_city']
      || @getSession('request_messages')->fieldsWithErrors['shipping_agency']
      || @getSession('request_messages')->fieldsWithErrors['shipping_zipcode']
      || @getSession('request_messages')->fieldsWithErrors['additional_notes']
    ) {
      return true;
    }
  }

  return false;
}

function shippingInfoIsIncomplete()
{
  if (empty(getGlobal('shipping_fulladdress'))) {
    return true;
  }

  return false;
}

function fieldHasError($field, $class)
{
  bind(
    !empty(getSession('request_messages'))
    && isset(getSession('request_messages')->fieldsWithErrors[$field])
    && getSession('request_messages')->fieldsWithErrors[$field]
      ? $class
      : ''
  );
}

function canUseBilling()
{
  $billing = getOrderBillingInfo(getCurrentCart()->order->id);

  if (empty($billing->billing_address) || empty($billing->billing_state) || empty($billing->billing_city)) {
    return false;
  } else {
    return true;
  }
}

function checkedInput($input)
{
  if (getGlobal('cart_shipping_method') !== null && getGlobal('cart_shipping_method') === $input) {
    return true;
  } else if (getGlobal('shipping_method') == $input && (getGlobal('cart_shipping_method') === null)) {
    return true;
  }

  return false;
}
