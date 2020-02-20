<?php

function isLoggedIn()
{
  return getSession('user') ? true : false;
}

function runLogin()
{
  $status = runLogin_checkIncomingData();

  if (!$status->succeeded) {
    return $status;
  }

  $sql = (
    'SELECT
        `nombre`,
        `apellido`,
        `email`,
        `rut`,
        `direccion`,
        `departamento`,
        `ciudad`,
        `telefono`,
        `celular`
      FROM
        `usuario`
      WHERE
        `email` = "' . getPostData('email') . '"
      AND
        `clave` = "' . md5(getPostData('pass') . getPostData('email')) . '"'
  );

  $user = getDB()->getObject($sql);

  if (empty($user)) {
    $status->succeeded        = false;
    $status->success          = '';
    $status->errors           = [];
    $status->warnings         = [
      'Email o Contraseña incorrectos'
    ];
    $status->fieldsWithErrors = [];
  }

  setSession('user', $user);
  $status->success = 'Ingresaste con éxito';

  return $status;
}

function runLogin_checkIncomingData()
{
  $status = newStatusObject();

  if (empty(getPostData('email'))) {
    $status->fieldsWithErrors['email'] = true;
    $status->errors[]                  = 'El email no puede ser vacío';
  } elseif (!preg_match(REG_EXP_EMAIL_FORMAT, getPostData('email'))) {
    $status->fieldsWithErrors['email'] = true;
    $status->errors[]                  = 'El email no tiene el formato correcto';
  }

  if (empty(getPostData('pass'))) {
    $status->fieldsWithErrors['pass'] = true;
    $status->errors[]                 = 'La contraseña no puede ser vacía';
  }

  if (!checkIfEmailExists(getPostData('email'))) {
    $status->fieldsWithErrors['email'] = true;
    $status->fieldsWithErrors['pass']  = true;
    $status->warnings[]                = 'Email o Contraseña incorrectos';
  }

  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }

  return $status;
}