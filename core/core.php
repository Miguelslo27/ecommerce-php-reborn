<?php

require_once('class.upload.php');
require_once('mailer/PHPMailerAutoload.php');
require_once('config.php');
require_once('helpers.php');
require_once('document.php');
require_once('auth.php');
require_once('user.php');
require_once('cart.php');
require_once('category.php');
require_once('article.php');

init();

function init()
{
  // @To-Do
  // setGlobal('site', loadSite());
  // setGlobal('user', loadUser());
  // setGlobal('cart', loadCart());

  // setGlobal('page', $page_name);
  // setGlobal('sub_page', $sub_page_name);

  processRequests();
}

function processRequests()
{
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
