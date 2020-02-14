<?php

session_start();

require_once('class.upload.php');
require_once('mailer/PHPMailerAutoload.php');
require_once('config.php');
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
  logToConsole('APP Version: ' . APP_VERSION);
  logToConsole('API Version: ' . API_VERSION);
  debug('App Starts here =====>', __FILE__, __FUNCTION__, __LINE__);

  // @To-Do
  setGlobal('site', loadSite());
  setGlobal('user', getCurrentUser());
  setGlobal('cart', getCurrentCart());

  debug('global:site = ' . json_encode(getGlobal('site')), __FILE__, __FUNCTION__, __LINE__);
  debug('global:user = ' . json_encode(getGlobal('user')), __FILE__, __FUNCTION__, __LINE__);
  debug('global:cart = ' . json_encode(getGlobal('car')), __FILE__, __FUNCTION__, __LINE__);

  processRequests();
}

function processRequests()
{
  debug('request:action = ' . getRequestData('action'), __FILE__, __FUNCTION__, __LINE__);

  if (getRequestData('action') === ACTION_LOGIN) {
    // @TODO
  }

  if (getRequestData('action') === ACTION_USER_REGISTRATION) {
    // @TODO
  }

  if (getRequestData('action') === ACTION_SAVE_CATEGORY) {
    // @TODO
  }

  if (getRequestData('action') === ACTION_SAVE_ARTICLE) {
    // @TODO
  }
}
