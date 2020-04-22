<?php

session_start();
require_once('requires.php');
init();

function init()
{
  logToConsole('', 'Environment: ' . getenv('ENV'));
  logToConsole('', 'APP Version: ' . APP_VERSION);
  logToConsole('', 'API Version: ' . API_VERSION);

  loadCart();

  processRequests();
}

function processRequests()
{
  if (
    getPostData('action') === ACTION_LOGIN
    && !empty(getServer('REQUEST_METHOD'))
    && strtolower(getServer('REQUEST_METHOD')) == 'post'
  ) {
    setSession('request_messages', runLogin());
  }

  if (getRequestData('action') === ACTION_LOGOUT) {
    setSession('request_messages', runLogout());
    header('Location: /');
    exit;
  }

  if (
    getPostData('action') === ACTION_USER_REGISTRATION
    && !empty(getServer('REQUEST_METHOD'))
    && strtolower(getServer('REQUEST_METHOD')) == 'post'
  ) {
    setSession('request_messages', registerNewUser());
  }

  /**
   * @TODO
   * Process action ACTION_USER_EDITION
   */
  
  logToConsole('ACTION', getPostData('action'), __FILE__, __FUNCTION__, __LINE__);
   
  if (
    getPostData('action') === ACTION_USER_EDITION
    && !empty(getServer('REQUEST_METHOD'))
    && strtolower(getServer('REQUEST_METHOD')) == 'post'
  ) {
    logToConsole('EDITING', 'USER', __FILE__, __FUNCTION__, __LINE__);
    setSession('request_messages', saveUserEdition());
  }

  if (getRequestData('action') == ACTION_ADD_TO_CART) {
    setSession('request_messages', addToCart());
    $query_str  = getQueryParams(['action' => null, 'aid' => null, 'qty' => null]);
    $redirectTo = getRequestURIPath() . (!empty($query_str) ? "?$query_str" : '');
    header("Location: $redirectTo");
    exit;
  }

  if (getRequestData('action') == ACTION_UPDATE_CART_BILLING_INFO) {
    setSession('request_messages', saveOrderBillingInfo());
  }


  if (getRequestData('action') == ACTION_UPDATE_CART_SHIPPING_INFO) {
    setSession('request_messages', saveOrderShippingInfo());
  }
  
  if (getPostData('action') === ACTION_SAVE_CATEGORY) {
    // @TODO
  }

  if (getPostData('action') === ACTION_SAVE_ARTICLE) {
    // @TODO
  }

  if (getPostData('action') === ACTION_SEND_EMAIL) {
    // @TODO
    logToConsole('getPostAll()', getPostAll(), __FILE__, __FUNCTION__, __LINE__);
  }
}
