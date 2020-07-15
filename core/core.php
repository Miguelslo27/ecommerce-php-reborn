<?php

session_start();
require_once('requires.php');
init();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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
    $articlePage = explode('/', getServer('REQUEST_URI'), -1);
    $redirectTo = getRequestURIPath() . (!empty($query_str) ? "?$query_str" : "") . (($articlePage[1] == 'articulo') ? ("?aid=" . getRequestData('aid')) : "");
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
    setSession('request_messages', sendEmail([
      'from'    => ['email' => getPostData('sendemail_from'), 'name' => getPostData('sendemail_name')],
      'to'      => ['admin' => 'federicososa999@gmail.com', 'user' => getPostData('sendemail_from')],
      'subject' => getPostData('sendemail_subject'),
      'body'    => getPostData('sendemail_message'),
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
    try {
      $mailer = new PHPMailer();
    
      //Server settings
      $mailer->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
      $mailer->isSMTP();                                         // Send using SMTP
      $mailer->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
      );
      $mailer->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
      $mailer->SMTPAuth   = true;                                // Enable SMTP authentication
      $mailer->Username   = '';                     // SMTP username
      $mailer->Password   = '';                               // SMTP password
      $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mailer->Port       = 587;                                 // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

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
    $status->fieldsWithErrors['sendemail_from'] = true;
    $status->errors[]               = 'El campo remitente no puede ser vacío';
  } else {
    checkEmailsAddresses($settings['from']['email'], $status, 'El correo <strong>' . $settings['from']['email'] . '</strong> tiene un formato de email incorrecto', 'sendemail_from');
  }
  if (empty($settings['to']['user'])) {
    $status->fieldsWithErrors['to'] = true;
    $status->errors[]               = 'El campo destinatario no puede ser vacío';
  } else {
    checkEmailsAddresses($settings['to'], $status, 'El correo <strong>' . $settings['to']['user'] . '</strong> tiene un formato de email incorrecto');
  }
  if (!empty($settings['cc'])) {
    checkEmailsAddresses($settings['cc'], $status, 'El correo <strong>' . $settings['cc'] . '</strong> tiene un formato de email incorrecto');
  }
  if (!empty($settings['bcc'])) {
    checkEmailsAddresses($settings['bcc'], $status, 'El correo <strong>' . $settings['bcc'] . '</strong> tiene un formato de email incorrecto');
  }
  if (empty($settings['body'])) {
    $status->fieldsWithErrors['sendemail_message'] = true;
    $status->errors[]                 = 'El campo mensaje no puede ser vacío';
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