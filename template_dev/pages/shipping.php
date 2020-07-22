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

    $categories = getCategories();

    setGlobal('categories', oneOf($categories, []));
    setGlobal('shipping_method', $shippingInfo->shipping_method);
    setGlobal('shippingAddress', $shippingAddress);
    setGlobal('shippingState', $shippingState);
    setGlobal('shippingCity', $shippingCity);
    setGlobal('shippingZipcode', $shippingZipcode);

    setGlobal('shipping_fulladdress', implode(', ', $shippingFullAddress));
    setGlobal('canUseDirection', useDirection());
    logToConsole('isset', getGlobal('canUseDirection'), __FILE__, __FUNCTION__, __LINE__);
    logToConsole('shippinginfo', empty(getCurrentUser()->address), __FILE__, __FUNCTION__, __LINE__);
    logToConsole('shippinginfo', (getCurrentUser()), __FILE__, __FUNCTION__, __LINE__);
    logToConsole('data', getPreformData('copy-billing-address', ''), __FILE__, __FUNCTION__, __LINE__);
    logToConsole('equidad', getPreformData('shipping', '') == "withdraw", __FILE__, __FUNCTION__, __LINE__);
    logToConsole('shipping_method', getGlobal('shipping_method'), __FILE__, __FUNCTION__, __LINE__);


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


function useDirection()
{
  if (empty(getCurrentUser()->address) || empty(getCurrentUser()->state) || empty(getCurrentUser()->city)) {
    return false;
  } else {
    return true;
  }
}


