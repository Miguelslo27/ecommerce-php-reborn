<?php

session_start();
require_once('requires.php');
init();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function init()
{
  logToConsole('', 'Environment: ' . getenv('ENV'));
  logToConsole('', 'APP Version: ' . APP_VERSION);
  logToConsole('', 'API Version: ' . API_VERSION);

  loadSite();
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
    if (getRequestURIPath() === "/articulo/") {
      $subarticles = getQueryParamsByName(['aaid'])['aaid'];
      $subarticles !== null ? $subarticles = "aid=$subarticles" : '';
      $query_str   = getQueryParams(['action' => null, 'qty' => null, 'aaid' => null]);
      $next_query  = oneOf($subarticles, $query_str);
      $redirectTo  = getRequestURIPath() . (!empty($query_str) ? "?$next_query" : '');
    } else {
      $query_str  = getQueryParams(['action' => null, 'aid' => null, 'qty' => null]);
      $redirectTo = getRequestURIPath() . (!empty($query_str) ? "?$query_str" : '');
    }
    header("Location: $redirectTo");
    exit;
  }

  if (getRequestData('action') == ACTION_UPDATE_CART_BILLING_INFO) {
    setSession('request_messages', saveOrderBillingInfo());
  }


  if (getRequestData('action') == ACTION_UPDATE_CART_SHIPPING_INFO) {
    setSession('request_messages', saveOrderShippingInfo());
  }
  
  if (getRequestData('action') === ACTION_EDIT_SITE) {
    setSession('request_messages', siteEdition());
  }

  if (getRequestData('action') === ACTION_EDIT_SITE_NETWORKS) {
    setSession('request_messages', siteNetworksEdition());
  }
  
  if (getPostData('action') === ACTION_SAVE_CATEGORY) {
    // @TODO
  }

  if (getPostData('action') === ACTION_SAVE_ARTICLE) {
    // @TODO
  }

  if (getPostData('action') === ACTION_SEND_EMAIL) {
    $from    = getPostData('sendemail_from');
    $name    = getPostData('sendemail_name');
    $phone   = getPostData('sendemail_phone');
    $subject = getPostData('sendemail_subject');
    $message = getPostData('sendemail_message');
    $body    = "
      <html>
      <head>
      <title></title>
      </head>
      <body>
      <div style='width:70%;background:#f1f1f1;margin:auto;text-align:center;padding:3rem;'>
        <h2>Contacto de $name</h2>
        <h3>Nuevo mensaje desde $from</h3>
        <h3>Asunto: $subject</h3>
        <h3>Contacto: $phone</h3>
        <p>$message</p>
      </div>
      </body>
      </html>";

    setSession('request_messages', sendEmail([
      'from'    => ['email' => 'admin@e-com.uy'],
      'to'      => ['user' => getPostData('sendemail_from')],
      'bcc'     => ['admin' => 'miguelmail2006@gmail.com'],
      'subject' => 'Contacto WEB: '.oneOf($subject, $from),
      'body'    => $body,
    ]));
  }

  if(getRequestData('action') == ACTION_OBTAIN_PASSWORD) {
    setSession('request_messages', obtain_password());
  }

  if(getRequestData('action') == ACTION_CHANGE_PASSWORD) {
    setSession('request_messages', change_password());
    if(getGlobal('change_pass_success')){
      setGlobal('change_pass_success', false);
      header('Location: /');
      exit;
    }
  }
}

function sendEmail($settings)
{
  $status = sendEmail_checkIncomingData($settings);
  
  if ($status->succeeded) {
    $mailer = new PHPMailer();
    $mailer->CharSet = 'utf-8';

    //Server settings
    $mailer->SMTPDebug = SMTP::DEBUG_OFF;
    $mailer->isSMTP();
    $mailer->SMTPOptions = array(
      'ssl' => array(
        'verify_peer'       => true,
        'verify_peer_name'  => true,
        'allow_self_signed' => true
      )
    );
    $mailer->SMTPAuth   = true;
    $mailer->Host       = SMTPHOST;
    $mailer->Username   = SMTPUSER;
    $mailer->Password   = SMTPPASS;
    $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Port       = 587;

    customAddAddresses($mailer, $settings['to']);

    if (!empty($settings['cc'])) {
      customAddAddresses($mailer, $settings['cc']);
    }

    if (!empty($settings['bcc'])) {
      customAddAddresses($mailer, $settings['bcc']);
    }

    $mailer->setFrom(@$settings['from']['email'], @$settings['from']['name']);
    $mailer->AddReplyTo(@$settings['from']['email'], @$settings['from']['name']);
    $mailer->isHTML(@$settings['isHTML']);
    $mailer->Subject = @$settings['subject'];
    $mailer->Body    = @$settings['body'];
    $mailer->AltBody = @$settings['body'];

    logToConsole('$mailer', $mailer, __FILE__, __FUNCTION__, __LINE__);

    if ($mailer->send()) {
      $status->succeeded = true;
      $status->success   = 'Tu correo fue enviado correctamente, gracias por contactarte.';
    } else {
      $status->succeeded = false;
      $status->errors[]  = 'No se ha podido enviar el correo, intenta más tarde.';
    }
  }

  return $status;
}

function sendEmail_checkIncomingData($settings)
{
  $status = newStatusObject();
  if (empty($settings['from']['email'])) {
    $status->fieldsWithErrors['sendemail_from'] = true;
    $status->errors[]                           = 'El campo remitente no puede ser vacío';
  } else {
    checkEmailsAddresses($settings['from']['email'], $status, 'El correo <strong>' . $settings['from']['email'] . '</strong> tiene un formato de email incorrecto', 'sendemail_from');
  }
  if (empty($settings['to']['user'])) {
    $status->fieldsWithErrors['to'] = true;
    $status->errors[]               = 'El campo destinatario no puede ser vacío';
  } else {
    checkEmailsAddresses($settings['to'], $status, 'El correo tiene un formato de email incorrecto');
  }
  if (!empty($settings['cc'])) {
    checkEmailsAddresses($settings['cc'], $status, 'El correo tiene un formato de email incorrecto');
  }
  if (!empty($settings['bcc'])) {
    checkEmailsAddresses($settings['bcc'], $status, 'El correo tiene un formato de email incorrecto');
  }
  if (empty($settings['body'])) {
    $status->fieldsWithErrors['sendemail_message'] = true;
    $status->errors[]                              = 'El campo mensaje no puede ser vacío';
  }
  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }
  return $status;
}

function checkEmailsAddresses($emails, $status, $message, $field = null) {
  switch(gettype($emails)) {
    case 'string':
      if (!preg_match(REG_EXP_EMAIL_FORMAT, $emails)) {
        $status->fieldsWithErrors[$field] = true;
        $status->errors[]               = $message;
      }
    break;
    case 'array':
      foreach($emails as $key => $value) {
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