<?php

session_start();

require_once('config.php');
require_once(CORE_LOCATION . '/lib/class.upload.php');
require_once(CORE_LOCATION . '/lib/mailer/PHPMailerAutoload.php');
require_once(CORE_LOCATION . '/api/helpers.php');
require_once(CORE_LOCATION . '/api/site.php');
require_once(CORE_LOCATION . '/api/document.php');
require_once(CORE_LOCATION . '/api/auth.php');
require_once(CORE_LOCATION . '/api/user.php');
require_once(CORE_LOCATION . '/api/cart.php');
require_once(CORE_LOCATION . '/api/category.php');
require_once(CORE_LOCATION . '/api/article.php');

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
    setGlobal(
      'request_' . ACTION_LOGIN . '_messages',
      runLogin()
    );
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
    setGlobal(
      'request_' . ACTION_USER_REGISTRATION . '_messages',
      registerNewUser()
    );
  }

  if (getRequestData('action') == ACTION_ADD_TO_CART) {
    setSession('request_messages', addToCart());
    $query_str  = getQueryParams(['action' => null, 'aid' => null, 'qty' => null]);
    $redirectTo = getRequestURIPath() . (!empty($query_str) ? "?$query_str" : '');
    header("Location: $redirectTo");
    exit;
  }

  if (getPostData('action') === ACTION_SAVE_CATEGORY) {
    // @TODO
  }

  if (getPostData('action') === ACTION_SAVE_ARTICLE) {
    // @TODO
  }
}
