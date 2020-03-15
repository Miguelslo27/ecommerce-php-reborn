<?php

function getCurrentUser()
{
  return getSession('user');
}

function isAdmin()
{
  if (!getCurrentUser()) {
    return false;
  }

  return getCurrentUser()->isadmin;
}

function getUserName() {
  if (!getCurrentUser()) return null;
  return getCurrentUser()->name;
}

function getUserId() {
  if (!getCurrentUser()) return null;
  return getCurrentUser()->id;
}

function registerNewUser() {
  $status = registerNewUser_checkIncomingData();

  if (!$status->succeeded) {
    return $status;
  }

  $sql = (
    'INSERT
      INTO
        `users`
        (
          `name`,
          `lastname`,
          `email`,
          `password`,
          `verification_code`,
          `document`,
          `address`,
          `state`,
          `city`,
          `phone`,
          `cellphone`
        )
      VALUES
      (
        "' . getPostData('name') . '",
        "' . getPostData('lastname') . '",
        "' . getPostData('reg_email') . '",
        "' . md5(getPostData('reg_pass') . getPostData('reg_email')) . '",
        "' . md5(getPostData('reg_email')) . '",
        "' . getPostData('document') . '",
        "' . getPostData('address') . '",
        "' . getPostData('state') . '",
        "' . getPostData('city') . '",
        "' . getPostData('phone') . '",
        "' . getPostData('cellphone') . '"
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

  $status->success = 'Te has registrado con éxito';

  return $status;
}

function registerNewUser_checkIncomingData()
{
  $status = newStatusObject();

  /**
   * if (
   *  $status = validateData([
   *    'regexp' => REG_EXP_NAME_FORMAT
   *  ], getPostData('name'), $status)
   * ) return $status; // El mensaje debería ser genérico según la validación hecha
   */
  if (empty(getPostData('name'))) {
    $status->fieldsWithErrors['name'] = true;
    $status->errors[]                 = 'Tu nombre no puede ser vacío';
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('name'))) {
    $status->fieldsWithErrors['name'] = true;
    $status->errors[]                 = 'El nombre tiene un formato incorrecto. Tu nombre puede incluir letras, espacios y puntos';
  }

  if (empty(getPostData('lastname'))) {
    $status->fieldsWithErrors['lastname'] = true;
    $status->errors[]                     = 'Tu apellido no puede ser vacío';
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('lastname'))) {
    $status->fieldsWithErrors['lastname'] = true;
    $status->errors[]                     = 'El apellido tiene un formato incorrecto. Tu nombre puede incluir letras, espacios y puntos';
  }

  if (!preg_match(REG_EXP_STRING_FORMAT, getPostData('address'))) {
    $status->fieldsWithErrors['address'] = true;
    $status->errors[]                    = 'La dirección tiene un formato inseguro. La dirección puede contener letras, espacios, números, puntos, comas y barras, pero no caracteres especiales';
    return $status;
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('state'))) {
    $status->fieldsWithErrors['state'] = true;
    $status->errors[]                  = 'El departamento tiene un formato inseguro. El departamento puede incluir letras, espacios y puntos';
    return $status;
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('city'))) {
    $status->fieldsWithErrors['city'] = true;
    $status->errors[]                 = 'La localidad tiene un formato inseguro. La localidad puede incluir letras, espacios y puntos';
    return $status;
  }

  if (empty(getPostData('reg_email'))) {
    $status->fieldsWithErrors['reg_email'] = true;
    $status->errors[]                      = 'El email no puede ser vacío';
  } elseif (!preg_match(REG_EXP_EMAIL_FORMAT, getPostData('reg_email'))) {
    $status->fieldsWithErrors['reg_email'] = true;
    $status->errors[]                      = 'El email no tiene el formato correcto';
  } elseif (checkIfEmailExists(getPostData('reg_email'))) {
    $status->fieldsWithErrors['reg_email'] = true;
    $status->errors[]                      = 'El email ya se encuentra registrado';
    return $status;
  }

  if (empty(getPostData('reg_pass'))) {
    $status->fieldsWithErrors['reg_pass'] = true;
    $status->fieldsWithErrors['pass2']    = true;
    $status->errors[]                     = 'La contraseña no puede ser vacía';
  } elseif (strlen(getPostData('reg_pass')) < 6) {
    $status->fieldsWithErrors['reg_pass'] = true;
    $status->fieldsWithErrors['pass2']    = true;
    $status->errors[]                     = 'Para una contraseña segura, esta debe tener más de 6 caracteres';
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

  if (empty(getPostData('document'))) {
    $status->fieldsWithErrors['document'] = true;
    $status->errors[]                = 'Ingresa el RUT de tu empresa o tu número de documento';
  } elseif (!preg_match(REG_EXP_NUMBER_FORMAT, getPostData(('document')))) {
    $status->fieldsWithErrors['document'] = true;
    $status->errors[]                = 'El RUT o número de documento no puede contener caracteres alfabéticos, puntos ni guiones, sólo números';
  }

  if (
    empty(getPostData('address'))
    || empty(getPostData('state'))
    || empty(getPostData('city'))
  ) {
    $status->warnings[] = 'Tu dirección, departamento y ciudad, serán necesarias para recibir tus compras, recuerda completar estos datos más adelante';
  }

  if (
    empty(getPostData('phone'))
    && empty(getPostData('cellphone'))
  ) {
    $status->fieldsWithErrors['phone'] = true;
    $status->fieldsWithErrors['cellphone']  = true;
    $status->errors[]                     = 'Debes ingresar al menos un número de teléfono, fijo o celular';
  } elseif (
    !empty(getPostData('phone'))
    && !preg_match(REG_EXP_STRING_NUMBER_FORMAT, getPostData('phone'))
  ) {
    $status->fieldsWithErrors['phone'] = true;
    $status->errors[]                     = 'El teléfono tiene un formato incorrecto. Puede incluir números, espacios y guiones';
  } elseif (
    !empty(getPostData('cellphone'))
    && !preg_match(REG_EXP_STRING_NUMBER_FORMAT, getPostData('cellphone'))
  ) {
    $status->fieldsWithErrors['cellphone'] = true;
    $status->errors[]                     = 'El celular tiene un formato incorrecto. Puede incluir números, espacios y guiones';
  }

  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }

  return $status;
}

function checkIfEmailExists($email) {
  return getDB()->countOf('users', "`email` = '$email'") > 0;
}
