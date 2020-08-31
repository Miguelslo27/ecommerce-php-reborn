<?php

function loadSite()
{
  logToConsole('', 'SITE');
  //CREATE SITE IF IT WASN´T
  $site_id = getIdSite();
  if ($site_id === null) {
    initSite();
  }

  $site = getSite();
  
  setGlobal('site', $site);
  //NETWORKS
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

function getIdSite() {
  $admin_id = getUserId();
  $sql = (
    "SELECT
      `id`
    FROM `site`
    WHERE `user_admin` = $admin_id"
  );

  $result = getDB()->getObjects($sql);
  if ($result !== null) {
    $result = $result[0]->id;
  } 

  return $result;
}


function getSite() {
  $site_id = getIdSite();
  $sql = (
    "SELECT
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

function getIdSiteNetworks() {
  $site_id = getIdSite();
  $sql = (
    "SELECT
      `id`
    FROM `site_networks`
    WHERE `site_id` = $site_id"
  );

  $result = getDB()->getObjects($sql);
  if ($result !== null) {
    $result = $result[0]->id;
  } 

  return $result;
}

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

function initSite() 
{
  $user_id   = getUserId();
  $sqlInsert = (
    "INSERT
      INTO `site` (
        `user_admin`,
        `name`
      )
      VALUES (
        $user_id,
        'DEMO'
      )"
  );
  
  getDB()->insert($sqlInsert);
}

function siteEdition()
{
  $status = siteEdition_checkIncomingData();
  if (!$status->succeeded) {
    return $status;
  };

  $site_id = getIdSite();
  $site = getSite();
  if (!empty($site_id)) {
    $sql = (
      'UPDATE
        `site`
        SET 
          `name`          = "' . oneOf(getPostData('site_name'), $site->name) . '",
          `description`   = "' . oneOf(getPostData('site_dscp'), $site->description) . '",
          `phone`         = "' . oneOf(getPostData('site_phone'), $site->phone) . '",
          `address`       = "' . oneOf(getPostData('site_address'), $site->address) . '",
          `contact_email` = "' . oneOf(getPostData('site_c_email'), $site->contact_email) . '",
          `contact_phone` = "' . oneOf(getPostData('site_c_phone'), $site->contact_phone) . '"
        WHERE
          `id` = "' . $site_id . '"'
      );
    if(!getDB()->query($sql)) {
      setSession('message', 'error al editar sitio');
      $status->succeeded = false;
      $status->errors[]  = 'Error al guardar los datos, vuelve a intentar';
      return $status;
    }     
  } else {
    $sqlInsert = (
    'INSERT
        INTO `site` (
          `user_admin`,
          `name`,
          `description`,
          `phone`,
          `address`,
          `contact_email`,
          `contact_phone`
        )
        VALUES (
          "' . getUserId() . '",
          "' . oneOf(getPostData('site_name'), 'DEMO') . '",
          "' . oneOf(getPostData('site_dscp'), '') . '",
          "' . oneOf(getPostData('site_phone'), '') . '",
          "' . oneOf(getPostData('site_address'), '') . '",
          "' . oneOf(getPostData('site_c_email'), '') . '",
          "' . oneOf(getPostData('site_c_phone'), '') . '"
        )'
    );
    if(!getDB()->insert($sqlInsert)) {
      setSession('message', 'error al crear sitio');
      $status->succeeded = false;
      $status->errors[]  = 'Error al guardar los datos, vuelve a intentar';
      return $status;
    } 
  }

  $status->success = 'Información guardada con éxito';
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

//SITE NETWORKS FUNCTION
function siteNetworksEdition($type) 
{
  $status      = newStatusObject();
  $site_id     = getIdSite();
  $networks_id = getIdSiteNetworks();
  $networks    = @getGlobal('uri_networks');
  $tag         = getRequestData('tag');
  $uri         = getRequestData('input');

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
          'nombre-de-ejemplo',
          $site_id
        )"
      );
    if(!getDB()->insert($sql)) {
      $status->succeeded = false;
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
      $status->errors[]  = 'La red no se puedo eliminar, intente de nuevo';
    }
    $status->success = 'Red eliminada con éxito';
    
  //EDIT NETWORK
  } else if ($type === 'edit-network') {
    //CHECK URI
    if (!empty($uri)) {
      if (!preg_match(REG_EXP_URI_FORMAT, $uri)) {
        $status->succeeded    = false;
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
      $status->succeeded = false;
      $status->errors[]  = 'Error al editar red, vuelve a intentar';
      return $status;
    }
    $status->success = 'Red editada con éxito';
  }

  $status->succeeded = true;
  return $status;
}

function getAdmins() {
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

function getAdmin($id) {
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

function siteAdminsEdition($type = "add-admin") {
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
        if ($admins[$i]->id === $id) {
          $status->errors[] = 'Este usuario ya es administrador';
          $status->succeeded = false;
          return $status;
        }
      }
    }  

    //USER DONT EXIST
    $sql = (
      "SELECT
        `id`
        FROM `users`
        WHERE `id` = $id
        AND `status` = 1"
    );
    $user = getDB()->getObjects($sql);
    if ($user === null) {
      $status->errors[] = 'Este usuario no existe';
      $status->succeeded = false;
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
      $status->succeeded = false;
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
      $status->succeeded = false;
      $status->errors[]  = "Error al añadir admin, vuelve a intentar";
      return $status;
    }

    $status->success = 'Admin añadido con éxito';
    $status->succeeded = true;
    return $status;
    
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
      $status->succeeded = false;
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
      $status->succeeded = false;
      $status->errors[]  = 'Error al eliminar admin, vuelve a intentar';
      return $status;
    }

    $status->success = 'Admin eliminado con éxito';
    $status->succeeded = true;
    return $status;

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
      $status->succeeded = false;
      $status->errors[]  = "Error al editar admin, vuelve a intentar $role $id";
      return $status;
    }

    $status->success = 'Admin editado con éxito';
    $status->succeeded = true;
    return $status;
  }
}