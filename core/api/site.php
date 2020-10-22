<?php

function loadSite()
{
  logToConsole('', getSite());
  logToConsole('', getAdmins());

  //LOAD SITE
  setGlobal('site', getSite());

  //SET NETWORKS
  $networks      = getSiteNetworks();
  $site_networks = new stdClass();
  $site_networks->facebook = null;
  $site_networks->twitter = null;
  $site_networks->instagram = null;
  $site_networks->youtube = null;

  for ($i = 0; $i < @count($networks); $i++) {
    switch ($networks[$i]->tag) {
      case 'facebook':
        $site_networks->facebook  = $networks[$i]->uri;
        break;
      case 'twitter':
        $site_networks->twitter   = $networks[$i]->uri;
        break;
      case 'instagram':
        $site_networks->instagram = $networks[$i]->uri;
        break;
      case 'youtube':
        $site_networks->youtube   = $networks[$i]->uri;
        break;
      default:
        logToConsole('', 'default'); 
    }
  }
  setGlobal('uri_networks', $site_networks);
}

function isSuperAdmin()
{
  $actual_user   = getUserId();
  $superadmin_id = getSuperAdminId();
  if ($actual_user === $superadmin_id) {
    return true;
  }
  return false;
}

function getSuperAdminId()
{
  $sql = (
    "SELECT
      `user_id`
    FROM `site_admins`
    WHERE `role` = 'superadmin'"
  );
  $result = getDB()->getObjects($sql);
  
  if ($result !== null) {
    $result = $result[0]->user_id;
  }
  return $result;
}

function getIdSite()
{
  $admin_id = getSuperAdminId();
  $sql = (
    "SELECT
      `id`
    FROM `site`
    WHERE `user_admin` = $admin_id"
  );
  $result = getDB()->getObjects($sql);

  if ($result !== null) {
    $result = end($result)->id;
  } 
  return $result;
}


function getSite()
{
  $site_id = getIdSite();
  $sql = (
    "SELECT
      `version_history`,
      `name`,
      `description`,
      `phone`,
      `address`,
      `contact_email`,
      `contact_phone`
    FROM `site`
    WHERE `id` = $site_id"
  );
  $result = getDB()->getObjects($sql);
  if ($result !== null) {
    $result = $result[0];
  } 
  
  return $result;
}

function siteEdition()
{
  $status = siteEdition_checkIncomingData();
  if (!$status->succeeded) {
    return $status;
  };

  $site_id = getIdSite();
  $site    = getSite();

  if (getPostData('site_name') === '') { 
    $site->name = '';
  }

  if (getPostData('site_dscp') === '') { 
    $site->description = '';
  }

  if (getPostData('site_phone') === '') { 
    $site->phone = '';
  }

  if (getPostData('site_address') === '') { 
    $site->address = '';
  }

  if (getPostData('site_c_email') === '') { 
    $site->contact_email = '';
  }

  if (getPostData('site_c_phone') === '') { 
    $site->contact_phone = '';
  }

  $sqlInsert = (
  'INSERT
      INTO `site` (
        `user_admin`,
        `version_history`,
        `name`,
        `description`,
        `phone`,
        `address`,
        `contact_email`,
        `contact_phone`
      )
      VALUES (
        "' . getSuperAdminId() . '",
        "' . ($site->version_history + 1) . '",
        "' . oneOf(getPostData('site_name'), $site->name) . '",
        "' . oneOf(getPostData('site_dscp'), $site->description) . '",
        "' . oneOf(getPostData('site_phone'), $site->phone) . '",
        "' . oneOf(getPostData('site_address'), $site->address) . '",
        "' . oneOf(getPostData('site_c_email'), $site->contact_email) . '",
        "' . oneOf(getPostData('site_c_phone'), $site->contact_phone) . '"
      )'
  );
  if(!getDB()->insert($sqlInsert)) {
    $status->succeeded = false;
    $status->errors[]  = 'Error al guardar los datos del sitio, vuelve a intentar';
    return $status;
  } 

  updateNetworksAdminId($site_id);
  $status->success = 'Información del sitio guardada con éxito';
  return $status;
}

function siteEdition_checkIncomingData()
{
  $status = newStatusObject();

  //CHECK NAME
  if (!empty(getPostData('site_name'))) {
    if (!preg_match(REG_EXP_STRING_FORMAT, getPostData('site_name'))) {
      $status->fieldsWithErrors['site_name']        = true;
      $status->errors[]                             = 'El nombre tiene un formato incorrecto, puede incluir letras, números y signos de puntuación';
    }
  }

  //CHECK DESCRIPTION
  if (!empty(getPostData('site_dscp'))) {
    if (!preg_match(REG_EXP_STRING_FORMAT, getPostData('site_dscp'))) {
      $status->fieldsWithErrors['site_dscp']        = true;
      $status->errors[]                             = 'La descripción tiene un formato incorrecto, puede incluir letras, números y signos de puntuación';
    }
  }

  //CHECK ADDRESS
  if (!empty(getPostData('site_address'))) {
    if (!preg_match(REG_EXP_STRING_FORMAT, getPostData('site_address'))) {
      $status->fieldsWithErrors['site_address']     = true;
      $status->errors[]                             = 'La descripción tiene un formato incorrecto, puede incluir letras, números y signos de puntuación';
    }
  }

  //CHECK PHONE
  if (!empty(getPostData('site_phone'))) {
    if (!preg_match(REG_EXP_NUMBER_FORMAT, getPostData('site_phone'))) {
      $status->fieldsWithErrors['site_phone']       = true;
      $status->errors[]                             = 'El telefono tiene un formato incorrecto, debe contener sólo números';
    }
  }

  //CHECK CONTACT EMAIL
  if (!empty(getPostData('site_c_email'))) {
    if (!preg_match(REG_EXP_EMAIL_FORMAT, getPostData('site_c_email'))) {
      $status->fieldsWithErrors['site_c_email']     = true;
      $status->errors[]                             = 'El email de contacto no tiene el formato correcto';
    }
  }

  //CHECK CONTACT PHONE
  if (!empty(getPostData('site_c_phone'))) {
    if (!preg_match(REG_EXP_NUMBER_FORMAT, getPostData('site_c_phone'))) {
      $status->fieldsWithErrors['site_c_phone']     = true;
      $status->errors[]                             = 'El telefono de contacto tiene un formato incorrecto, debe contener sólo números';
    }
  }
  
  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }

  return $status;
}

function updateNetworksAdminId($site_id)
{
  $current_id = getIdSite();
  $status    = newStatusObject();

  $sqlAdmin = (
    "UPDATE
        `site_admins`
      SET 
        `site_id` = $current_id
      WHERE
        `site_id` = $site_id"
  );
  if(!getDB()->query($sqlAdmin)) {
    $status->errors[]  = 'Error al actualizar admin, vuelve a intentar';
    return $status;
  }

  $sqlNetwork = (
    "UPDATE
        `site_networks`
      SET 
        `site_id` = $current_id
      WHERE
        `site_id` = $site_id"
  );
  if(!getDB()->query($sqlNetwork)) {
    $status->errors[]  = 'Error al actualizar redes, vuelve a intentar';
    return $status;
  }
}

//NETWORKS FUNCTIONS
function getSiteNetworks()
{
  $site_id = getIdSite();
  $sql = (
    "SELECT
      `tag`,
      `uri`
    FROM `site_networks`
    WHERE `site_id` = $site_id"
  );  

  return getDB()->getObjects($sql);
}

function allSiteNetworksDisplayed()
{
  $networks = getSiteNetworks();
  if ($networks === null) {
    $displayed = false;
  } else {
    if (count($networks) === 4) {
      $displayed = true;
    } else {
      $displayed = false;
    }
  }
  
  return $displayed;
}

function siteNetworksEdition($type) 
{
  $status    = newStatusObject();
  $site_id   = getIdSite();
  $networks  = @getGlobal('uri_networks');
  $tag       = getRequestData('tag');
  $uri       = getRequestData('input');

  //ADD NEW NETWORK
  if ($type === "add-network") {
    $sql = (
      "INSERT
        INTO `site_networks` (
          `tag`,
          `uri`,
          `site_id`
        ) 
        VALUES (
          '$tag',
          '',
          $site_id
        )"
      );
    if(!getDB()->insert($sql)) {
      $status->errors[]  = "La red no se pudo añadir, intente de nuevo";
      return $status;
    }
    $status->success = 'Red añadida con éxito';

  //DELETE NETWORK 
  } else if ($type === 'remove-network') {
    $sql = (
      "DELETE
        FROM 
          `site_networks` 
        WHERE 
          `site_id` = $site_id
        AND
          `tag`     =  '$tag'"
    );
    if(!getDB()->query($sql)) {
      $status->errors[] = 'La red no se puedo eliminar, intente de nuevo';
      return $status;
    }
    $status->success = 'Red eliminada con éxito';
    
  //EDIT NETWORK
  } else if ($type === 'edit-network') {
    //CHECK URI
    if (!empty($uri)) {
      if (!preg_match(REG_EXP_URI_FORMAT, $uri)) {
        $status->errors[]     = 'El formato es incorrecto';
        return $status;
      }
    }
    $sql = (
      "UPDATE
        `site_networks`
        SET 
          `uri`     = '$uri'
        WHERE
          `site_id` = $site_id
        AND
          `tag`     = '$tag'"
      );
    if(!getDB()->query($sql)) {
      $status->errors[]  = 'Error al editar red, vuelve a intentar';
      return $status;
    }
    $status->success = 'Red editada con éxito';
  }

  $status->succeeded = true;
  return $status;
}

//ADMINS FUNCTION
function getAdmins()
{
  $site_id = getIdSite();
  $sql = (
    "SELECT
      *
      FROM 
        `users`
      JOIN
        `site_admins`
      WHERE
        users.id = site_admins.user_id
      AND
        site_admins.site_id = $site_id"
  );

  return getDB()->getObjects($sql);
}

function getAdmin($id)
{
  $site_id = getIdSite();
  $sql = (
    "SELECT
      *
      FROM 
        `users`
      JOIN
        `site_admins`
      WHERE
        users.id = site_admins.user_id
      AND
        site_admins.site_id = $site_id
      AND
        site_admins.user_id = $id"
  );
  $admin = getDB()->getObjects($sql);
  if ($admin !== null) {
    return $admin[0];
  } else {
    return $admin;
  }
}

function siteAdminsEdition($type = "add-admin")
{
  $status  = newStatusObject();
  $site_id = getIdSite();
  $id      = getRequestData('id');
  $role    = getRequestData('role');
  
  //ADD ADMIN
  if ($type === "add-admin") {
    
    //USER ALREADY ADMIN
    $admins = getAdmins();
    if ($admins !== null) {
      for ($i = 0; $i < count($admins); $i++) {
        if ($admins[$i]->user_id === $id) {
          $status->errors[]  = 'Este usuario ya es administrador';
          return $status;
        }
      }
    }  

    //USER DONT EXIST
    $sql = (
      "SELECT
        `id`
        FROM `users`
        WHERE `id`   = $id
        AND `status` = 1"
    );
    $user = getDB()->getObjects($sql);
    if ($user === null) {
      $status->errors[]  = 'Este usuario no existe';
      return $status;
    }
    
    //ADD ISADMIN IN USER
    $sql = (
      "UPDATE
        `users`
      SET
        `isAdmin` = 1
      WHERE
        `id` = $id  
      "
    );
    if(!getDB()->query($sql)) {
      $status->errors[]  = 'Error al añadir admin, vuelve a intentar';
      return $status;
    }

    //ADD IN SITE ADMINS
    $sql = (
      "INSERT
        INTO `site_admins` (
          `user_id`,
          `role`,
          `site_id`
        )
        VALUES (
          $id,
          '$role',
          $site_id
        )"
    );
    if(!getDB()->insert($sql)) {
      $status->errors[]  = "Error al añadir admin, vuelve a intentar";
      return $status;
    }
    $status->success   = 'Admin añadido con éxito';
    
  } else if ($type === 'remove-admin') {
    //CHANGE ISADMIN IN USERS
    $sql = (
      "UPDATE
        `users`
      SET
        `isAdmin` = 0
      WHERE
        `id` = $id  
      "
    );
    if(!getDB()->query($sql)) {
      $status->errors[]  = 'Error al eliminar admin, vuelve a intentar';
      return $status;
    }

    //DELETE FROM SITE ADMINS
    $sql = (
      "DELETE
        FROM 
          `site_admins` 
        WHERE 
          `user_id` = $id
        AND 
          `site_id` = $site_id"
      );
    if(!getDB()->query($sql)) {
      $status->errors[]  = 'Error al eliminar admin, vuelve a intentar';
      return $status;
    }
    $status->success   = 'Admin eliminado con éxito';

  //EDIT ADMIN
  } else if ('edit-admin') {
    $sql = (
      "UPDATE
        `site_admins`
      SET
        `role`    = '$role'
      WHERE
        `user_id` = $id
      AND
        `site_id` = $site_id
      "
    );

    if(!getDB()->query($sql)) {
      $status->errors[]  = "Error al editar admin, vuelve a intentar $role $id";
      return $status;
    }

    $status->success   = 'Admin editado con éxito';
  }

  $status->succeeded = true;
  return $status;
}