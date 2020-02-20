<?php

function getCurrentUser()
{
  return getGlobal('user');
}

function isAdmin()
{
  if (!getCurrentUser()) {
    return false;
  }

  return getCurrentUser()->administrador;
}

function getUserName() {
  if (!getCurrentUser()) return null;
  return getCurrentUser()->nombre;
}

function getUserId() {
  if (!getCurrentUser()) return null;
  return getCurrentUser()->id;
}

function registerNewUser() {
  $status = registerNewUser_checkIncomingData();

  if (!$status->success) {
    return $status;
  }

  $sql = (
    'INSERT
      INTO `usuario`
      (
        `nombre`,
        `apellido`,
        `email`,
        `clave`,
        `codigo`,
        `rut`,
        `direccion`,
        `departamento`,
        `ciudad`,
        `telefono`,
        `celular`
      )
      VALUES
      (
        "' . getPostData('nombre') . '",
        "' . getPostData('apellido') . '",
        "' . getPostData('reg_email') . '",
        "' . md5(getPostData('reg_pass') . getPostData('reg_email')) . '",
        "' . md5(getPostData('reg_email')) . '",
        "' . getPostData('rut') . '",
        "' . getPostData('direccion') . '",
        "' . getPostData('departamento') . '",
        "' . getPostData('ciudad') . '",
        "' . getPostData('telefono') . '",
        "' . getPostData('celular') . '"
      )'
  );

  $uid = getDB()->insert($sql);

  if (empty($uid)) {
    $status->succeeded        = false;
    $status->success          = '';
    $status->errors           = [
      'Hubo un error al guardar tus datos, inténtalo de nuevo'
    ];
    $status->warnings         = [];
    $status->fieldsWithErrors = [];
  }

  return $status;
}

function registerNewUser_checkIncomingData()
{
  $status                   = new stdClass();
  $status->succeeded        = false;
  $status->success          = '';
  $status->errors           = [];
  $status->warnings         = [];
  $status->fieldsWithErrors = [];

  /**
   * if (
   *  $status = validateData([
   *    'regexp' => REG_EXP_NAME_FORMAT
   *  ], getPostData('nombre'), $status)
   * ) return $status; // El mensaje debería ser genérico según la validación hecha
   */
  if (!preg_match(REG_EXP_NAME_FORMAT, getPostData('nombre'))) {
    $status->fieldsWithErrors['nombre'] = true;
    $status->errors[]                   = 'El nombre tiene un formato inseguro. Tu nombre puede incluir letras, espacios y puntos';
    return $status;
  }

  if (!preg_match(REG_EXP_NAME_FORMAT, getPostData('apellido'))) {
    $status->fieldsWithErrors['apellido'] = true;
    $status->errors[]                     = 'El apellido tiene un formato inseguro. Tu nombre puede incluir letras, espacios y puntos';
    return $status;
  }

  if (!preg_match(REG_EXP_STRING_FORMAT, getPostData('direccion'))) {
    $status->fieldsWithErrors['direccion'] = true;
    $status->errors[]                      = 'La dirección tiene un formato inseguro. La dirección puede contener letras, espacios, números, puntos, comas y barras, pero no caracteres especiales';
    return $status;
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('departamento'))) {
    $status->fieldsWithErrors['departamento'] = true;
    $status->errors[]                         = 'El departamento tiene un formato inseguro. El departamento puede incluir letras, espacios y puntos';
    return $status;
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('ciudad'))) {
    $status->fieldsWithErrors['ciudad'] = true;
    $status->errors[]                   = 'La localidad tiene un formato inseguro. La localidad puede incluir letras, espacios y puntos';
    return $status;
  }

  if (empty(getPostData('reg_email'))) {
    $status->fieldsWithErrors['reg_email'] = true;
    $status->errors[]                      = 'El email no puede ser vacío';
  } elseif (!preg_match(REG_EXP_EMAIL_FORMAT, getPostData('reg_email'))) {
    $status->fieldsWithErrors['reg_email'] = true;
    $status->errors[]                      = 'El email no tiene el formato correcto';
  } elseif (checkIfEmailAlreadyExists(getPostData('reg_email'))) {
    $status->fieldsWithErrors['reg_email'] = true;
    $status->errors[]                      = 'El email ya se encuentra registrado';
    return $status;
  }

  if (empty(getPostData('reg_pass'))) {
    $status->fieldsWithErrors['reg_pass'] = true;
    $status->fieldsWithErrors['pass2']    = true;
    $status->errors[] = 'La contraseña no puede ser vacía';
  } elseif (strlen(getPostData('reg_pass')) < 6) {
    $status->fieldsWithErrors['reg_pass'] = true;
    $status->fieldsWithErrors['pass2']    = true;
    $status->errors[] = 'Para una contraseña segura, esta debe tener más de 6 caracteres';
  } else {
    if (
      empty(getPostData('pass2'))
      || getPostData('reg_pass') !== getPostData('pass2')
    ) {
      $status->fieldsWithErrors['reg_pass'] = true;
      $status->fieldsWithErrors['pass2']    = true;
      $status->errors[]                     = 'Las contraseñas deben coincidir, por seguridad';
    }
  }

  if (empty(getPostData('rut'))) {
    $status->fieldsWithErrors['rut'] = true;
    $status->errors[]                = 'Ingresa el RUT de tu empresa o tu número de documento';
  } elseif (!preg_match(REG_EXP_NUMBER_FORMAT, getPostData(('rut')))) {
    $status->fieldsWithErrors['rut'] = true;
    $status->errors[]                = 'El RUT o número de documento no puede contener caracteres alfabéticos, puntos ni guiones, sólo números';
  }

  if (
    empty(getPostData('direccion'))
    || empty(getPostData('departamento'))
    || empty(getPostData('ciudad'))
  ) {
    $status->warnings[] = 'Tu dirección, departamento y ciudad, serán necesarias para recibir tus compras, recuerda completar estos datos más adelante';
  }

  if (
    empty(getPostData('telefono'))
    && empty(getPostData('celular'))
  ) {
    $status->fieldsWithErrors['telefono'] = true;
    $status->fieldsWithErrors['celular']  = true;
    $status->errors[]                     = 'Debes ingresar al menos un número de teléfono, fijo o celular';
  }

  if (count($status->errors) == 0) {
    $status->succeeded = true;
    $status->success   = 'Te has registrado con éxito';
  }

  return $status;
}

function checkIfEmailAlreadyExists($email) {
  return getDB()->countOf('usuario', "`email` = '$email'") > 0;
}
