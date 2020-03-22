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
    $billingName         = oneOf($billingInfo->billing_name, getCurrentUser()->name . ' ' .getCurrentUser()->lastname);
    $billingDocument     = oneOf($billingInfo->billing_document, getCurrentUser()->document);
    $billingAddress      = oneOf($billingInfo->billing_address, getCurrentUser()->address);
    $billingState        = oneOf($billingInfo->billing_state, getCurrentUser()->state);
    $billingCity         = oneOf($billingInfo->billing_city, getCurrentUser()->city);
    $billingZipcode      = oneOf($billingInfo->billing_zipcode, '');
    $billingFullAddress  = array();
    $phones              = array();

    if (!empty(getCurrentUser()->phone)) {
      $phones[] = getCurrentUser()->phone;
    }

    if (!empty(getCurrentUser()->cellphone)) {
      $phones[] = getCurrentUser()->cellphone;
    }

    if (!empty($billingAddress)) {
      $billingFullAddress[] = $billingAddress;
    }

    if (!empty($billingState)) {
      $billingFullAddress[] = $billingState;
    }

    if (!empty($billingCity)) {
      $billingFullAddress[] = $billingCity;
    }

    if (!empty($billingInfo->billing_zipcode)) {
      $billingFullAddress[] = $billingZipcode;
    }

    $shippingInfo        = getOrderShippingInfo(getCurrentCart()->order->id);
    $shippingAddress     = $shippingInfo->shipping_address;
    $shippingState       = $shippingInfo->shipping_state;
    $shippingCity        = $shippingInfo->shipping_city;
    $shippingZipcode     = $shippingInfo->shipping_zipcode;
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

    setGlobal('billing_name', $billingName);
    setGlobal('billing_document', $billingDocument);
    setGlobal('billing_fulladdress', implode(', ', $billingFullAddress));
    setGlobal('billing_address', $billingAddress);
    setGlobal('billing_state', $billingState);
    setGlobal('billing_city', $billingCity);
    setGlobal('billing_zipcode', $billingZipcode);
    setGlobal('phones', implode(' / ', $phones));
    setGlobal('shipping_method', $shippingInfo->shipping_method);
    setGlobal('shipping_fulladdress', implode(', ', $shippingFullAddress));
  }
]);

function billingInfoFormHasErrors()
{
  if (!empty(getSession('request_messages'))) {
    if (
      @getSession('request_messages')->fieldsWithErrors['billing_name']
      || @getSession('request_messages')->fieldsWithErrors['billing_document']
      || @getSession('request_messages')->fieldsWithErrors['billing_address']
      || @getSession('request_messages')->fieldsWithErrors['billing_state']
      || @getSession('request_messages')->fieldsWithErrors['billing_city']
      || @getSession('request_messages')->fieldsWithErrors['billing_zipcode']
    ) {
      return true;
    }
  }

  return false;
}

function billingInfoIsIncomplete()
{
  if (
    empty(getGlobal('billing_document'))
    || empty(getGlobal('billing_fulladdress'))
  ) {
    return true;
  }

  return false;
}

function shippingInfoFormHasErrors()
{
  if (!empty(getSession('request_messages'))) {
    if (
      @getSession('request_messages')->fieldsWithErrors['shipping_address']
      || @getSession('request_messages')->fieldsWithErrors['shipping_state']
      || @getSession('request_messages')->fieldsWithErrors['shipping_city']
      || @getSession('request_messages')->fieldsWithErrors['shipping_agency']
      || @getSession('request_messages')->fieldsWithErrors['shipping_zipcode']
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
