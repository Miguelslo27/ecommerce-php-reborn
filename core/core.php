<?php

session_start();
require_once('requires.php');
init();

use PHPMailer\PHPMailer\PHPMailer;

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

  /* 
  sendemail_name
  sendemail_subject
  sendemail_message
   */
  
  if (getPostData('action') === ACTION_SEND_EMAIL) {
    // @TODO
    logToConsole('getPostAll()', getPostAll(), __FILE__, __FUNCTION__, __LINE__);
    setSession('request_messages', sendEmail([
      'from' => ['email' => getPostData('sendemail_from'), 'name' => getPostData('sendemail_name')],
      'to'   => 'miguelmail2006@gmail.com',
      'subject' => getPostData('sendemail_subject'),
      'bodyt' => getPostData('sendemail_message'),
    ]));
  }
}

function sendEmail($settings)
{
  // @TODO
  $status = sendEmail_checkIncomingData($settings);

  logToConsole('$status', $status, __FILE__, __FUNCTION__, __LINE__);
  
  if ($status->succeeded) {
    try {
      $mailer = new PHPMailer();
    
      customAddAddresses($mailer, $settings['to']);
      
      if (!empty($settings['cc'])) {
        customAddAddresses($mailer, $settings['cc']);
      }

      if (!empty($settings['bcc'])) {
        customAddAddresses($mailer, $settings['bcc']);
      }

      $mailer->setFrom(@$settings['from']['email'], @$settings['from']['name']);
      $mailer->isHTML(@$settings['isHTML']);
      $mailer->Subject = @$settings['subject'];
      $mailer->Body    = @$settings['body'];
      $mailer->AltBody = @$settings['body'];
      $mailer->send();

      logToConsole('$mailer', $mailer, __FILE__, __FUNCTION__, __LINE__);

      $status->success = 'Tu correo fue enviado correctamente, gracias por contactarte.';
    } catch(Exception $e) {
      $status->succeeded = false;
      $status->errors[]  = 'No se ha podido enviar el correo, intenta más tarde.';
      $status->errors[]  = $mailer->ErrorInfo;
    }
  }

  return $status;
}

function sendEmail_checkIncomingData($settings)
{
  $status = newStatusObject();

  if (empty($settings['from']['email'])) {
    $status->fieldsWithErrors['from'] = true;
    $status->errors[]                 = 'El campo remitente no puede ser vacío';
  } else {
    checkEmailsAddresses($settings['from']['email'], $status, 'El correo <strong>' . $settings['from']['email'] . '</strong> tiene un formato de email incorrecto');
  }

  if (empty($settings['to'])) {
    $status->fieldsWithErrors['to'] = true;
    $status->errors[]               = 'El campo destinatario no puede ser vacío';
  } else {
    checkEmailsAddresses($settings['to'], $status, 'El correo <strong>' . $settings['to'] . '</strong> tiene un formato de email incorrecto');
  }

  if (!empty($settings['cc'])) {
    checkEmailsAddresses($settings['cc'], $status, 'El correo <strong>' . $settings['cc'] . '</strong> tiene un formato de email incorrecto');
  }

  if (!empty($settings['bcc'])) {
    checkEmailsAddresses($settings['bcc'], $status, 'El correo <strong>' . $settings['bcc'] . '</strong> tiene un formato de email incorrecto');
  }

  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }

  return $status;
}

function checkEmailsAddresses($emails, $status, $message) {
  switch(gettype($emails)) {
    case 'string':
      if (!preg_match(REG_EXP_EMAIL_FORMAT, $emails)) {
        $status->fieldsWithErrors['to'] = true;
        $status->errors[]               = $message;
      }
    break;
    case 'array':
      foreach($emails as $value) {
        if (!preg_match(REG_EXP_EMAIL_FORMAT, $value)) {
          $status->fieldsWithErrors['to'] = true;
          $status->errors[]               = $message;
        }
      }
    break;
  }
}

function customAddAddresses($mailer, $emails)
{
  switch(gettype($emails)) {
    case 'string':
      $mailer->addAddress($emails);
    break;
    case 'array':
      foreach($emails as $value) {
        $mailer->addAddress($value);
      }
    break;
  }
}

/*
sendEmail([
  'from' => [ email => '', name => '' ]
  'to' => 'string' || [
    miguelmail2006@gmail.com,
    fulanito@email.com,
  ],
  'cc' => 'string' || [],
  'bbc' => 'string || [],
  'subject' => 'string',
  'body' => 'string',
  'isHTML' => true || false,
  'attachments' => [[
    'file'
    'type'
  ]]
])
*/