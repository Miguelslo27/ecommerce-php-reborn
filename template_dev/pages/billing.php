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
  'scripts' => [
    'components/forms/payment/billing.js'
  ],
  'beforeRender' => function() {
    if (!isLoggedIn()) {
      header('Location: /login');
      exit;
    }

    if (!getCurrentCart() || count(getCurrentCart()->articles) == 0) {
      header('Location: /carrito');
      exit;
    }

    $billingInfo        = getOrderBillingInfo(getCurrentCart()->order->id);
    $billingName        = $billingInfo->billing_name;
    $billingDocument    = $billingInfo->billing_document;
    $billingAddress     = $billingInfo->billing_address;
    $billingState       = $billingInfo->billing_state;
    $billingCity        = $billingInfo->billing_city;
    $billingZipcode     = $billingInfo->billing_zipcode;
    $billingFullAddress = array();
    $notFullAddress     = false;

    if (!empty($billingAddress)) {
      $billingFullAddress[] = $billingAddress;
    } else {
      $notFullAddress = true;
    }

    if (!empty($billingState)) {
      $billingFullAddress[] = $billingState;
    } else {
      $notFullAddress = true;
    }

    if (!empty($billingCity)) {
      $billingFullAddress[] = $billingCity;
    } else {
      $notFullAddress = true;
    }

    $categories         = getCategories();

    setGlobal('categories', oneOf($categories, []));
    setGlobal('billingName', $billingName);
    setGlobal('billingDocument', $billingDocument);
    setGlobal('billingAddress', $billingAddress);
    setGlobal('billingState', $billingState);
    setGlobal('billingCity', $billingCity);
    setGlobal('billingZipcode', $billingZipcode);
    setGlobal('billingFullAddress', implode(', ', $billingFullAddress));
    setGlobal('notFullAddress', $notFullAddress);
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
  if (getGlobal('notFullAddress')) {
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