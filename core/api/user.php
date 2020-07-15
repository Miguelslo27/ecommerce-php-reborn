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
  $status = user_checkIncomingData(true);

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
  } else {
    $status->success = 'Te has registrado con éxito';
  }
  
  return $status;
}

function saveUserEdition()
{
  $status = user_checkIncomingData(false);
  
  if (!$status->succeeded) {
    return $status;
  }
  
  // @TODO
  $sql = (
    'UPDATE
      `users`
      SET 
        `name` = "' . getPostData('name') . '",
        `lastname` = "' . getPostData('lastname') . '",
        `address` = "' . getPostData('address') . '",
        `state` = "' . getPostData('state') . '",
        `city` = "' . getPostData('city') . '",
        `phone` = "' . getPostData('phone') . '",
        `cellphone` = "' . getPostData('cellphone') . '"
      WHERE
        `id` = ' . getUserId()
    );
  
  if(!getDB()->query($sql)) {
    $status->succeeded        = false;
    $status->success          = '';
    $status->errors           = [
      'Hubo un error al guardar tus datos, inténtalo de nuevo'
    ];
    $status->warnings         = [];
    $status->fieldsWithErrors = [];
  } else {
    $status->success = 'Tus datos se salvaron con éxito';
  }

  return $status;
}

function user_checkIncomingData($isANewUser = false)
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

  if ($isANewUser) {
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
  }

  if ($isANewUser) {
    if (strlen(getPostData('reg_pass')) < 6) {
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
  } else {
    if (!empty(getPostData('reg_pass')) && strlen(getPostData('reg_pass')) < 6) {
      $status->fieldsWithErrors['reg_pass'] = true;
      $status->fieldsWithErrors['pass2']    = true;
      $status->errors[]                     = 'Para una contraseña segura, esta debe tener más de 6 caracteres';
    } else {
      if (getPostData('reg_pass') !== getPostData('pass2')) {
        $status->fieldsWithErrors['reg_pass'] = true;
        $status->fieldsWithErrors['pass2']    = true;
        $status->errors[]                     = 'Las contraseñas deben coincidir, por seguridad';
      }
    }
  }

  if ($isANewUser) {
    if (empty(getPostData('document'))) {
      $status->fieldsWithErrors['document'] = true;
      $status->errors[]                     = 'Ingresa el RUT de tu empresa o tu número de documento';
    } elseif (!preg_match(REG_EXP_NUMBER_FORMAT, getPostData(('document')))) {
      $status->fieldsWithErrors['document'] = true;
      $status->errors[]                     = 'El RUT o número de documento no puede contener caracteres alfabéticos, puntos ni guiones, sólo números';
    }
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

function loadUser($email)
{
  $sql = (
    "SELECT
        `id`,
        `name`,
        `lastname`,
        `email`,
        `document`,
        `address`,
        `state`,
        `city`,
        `phone`,
        `cellphone`,
        `isadmin`
      FROM
        `users`
      WHERE
        `email` = '$email'"
  );
  $user = getDB()->getObject($sql);
  return $user;
}

function obtain_password() 
{
  $status = newStatusObject();
  $email  = getPostData('email');

  if (empty($email)) {
    $status->fieldsWithErrors['email'] = true;
    $status->errors[]                  = 'El correo para restaurar su contraseña no puede ser vacío';
  } else if (!preg_match(REG_EXP_EMAIL_FORMAT, $email)) {
    $status->fieldsWithErrors['email'] = true;
    $status->errors[]                  = 'El correo <strong>' . $email . '</strong> tiene un formato de email incorrecto';
  } else {
    $sql = (
      "SELECT
          `id`,
          `verification_code`
        FROM
          `users`
        WHERE
          `email` = '$email'"
    );
    $user = getDB()->getObject($sql);

    logToConsole('obtain_password:$user', $user, __FILE__, __FUNCTION__, __LINE__);

    if ($user != null) {
      $url="http://demo.ecommerce.local/recuperar-clave/?email=$email&activation=$user->verification_code";
      $body = "
        <html>
        <head>
        <title></title>
        </head>
        <body>     
        <div style='width:70%;background:#f1f1f1;margin:auto;text-align:center;padding:3rem;'>
          <h2>Hola $email,</h2>
          <h3 style='margin-bottom:4rem;'>Hemos recibido una solicitud de nueva contraseña para acceder a Nombre Empresa</h3>
          <a style='padding:1rem 2rem;background:#930077;color:#fff;font-size:16px;text-decoration:none;' href=$url>Pulsa aquí para recibir la nueva contraseña.</a>
        </div>
        </body>
        </html>";
      
      $status = sendEmail([
        'from'    => ['email' => 'miguelmail2006@gmail.com', 'name' => 'Nombre Empresa'],
        // 'to'      => ['user' => $email],
        'to'      => ['user' => 'miguelmail2006@gmail.com'],
        'subject' => 'Recuperar Contraseña',
        'body'    => $body,
        'isHTML'  => true,
      ]);
    }

    logToConsole('obtain_password:$status', $status, __FILE__, __FUNCTION__, __LINE__);

    $status->succeeded = true;
    $status->success = 'Tu correo fue enviado correctamente, gracias por contactarte.';
  }

  return $status;
}

function change_password()
{
  $status     = newStatusObject();
  $keys       = explode("=", getServer('QUERY_STRING'));
  @$email      = explode("&", $keys[1]);
  $email      = $email[0];
  @$activation = $keys[2];
  $pswd       = getPostData('pswrd');

  $sql = (
    "SELECT
        `id`,
        `email`
      FROM
        `users`
      WHERE
        `verification_code` = '$activation'
      AND
        `email` = '$email'"
  );
  $actual_user = getDB()->getObject($sql);

  if ($actual_user == null) {
    $status->fieldsWithErrors['pswrd']         = true;
    $status->fieldsWithErrors['pswrd_confirm'] = true;
    $status->errors[]                          = 'Hubo un error en el codigo de activacion';
  } else if (strlen(getPostData('pswrd')) < 6) {
    $status->fieldsWithErrors['pswrd']         = true;
    $status->fieldsWithErrors['pswrd_confirm'] = true;
    $status->errors[]                          = 'Para una contraseña segura, esta debe tener más de 6 caracteres';
  } else if (
    empty(getPostData('pswrd_confirm')) 
    || getPostData('pswrd') !== getPostData('pswrd_confirm')
  ) {
    $status->fieldsWithErrors['pswrd']         = true;
    $status->fieldsWithErrors['pswrd_confirm'] = true;
    $status->errors[]                          = 'Las contraseñas deben coincidir, por seguridad';
  } 
  else {
    $pass             = md5($pswd . $email);
    $new_verification = md5($pswd . $actual_user->id);
    $sql = (
      "UPDATE
          `users`
        SET
          `password` = '$pass',
          `verification_code` = '$new_verification'
        WHERE
          `email` = '$email'"
    );

    if (!getDB()->query($sql)) {
      $status->fieldsWithErrors['pswrd']         = true;
      $status->fieldsWithErrors['pswrd_confirm'] = true;
      $status->errors[]                          = 'Hubo un error al cambiar tu contraseña, inténtalo de nuevo';
    } else {
      $status->succeeded = true;
      $status->success   = 'Tu contraseña se modifico con éxito';
      setGlobal('change_pass_success', true);
    }
  } 
  
  return $status;
}