<?php

function getCurrentCart()
{
  return getSession('cart');
}

function addToCart($qty = 1)
{
  $status = addToCart_checkIncommingData($qty);

  if (!$status->succeeded) {
    return $status;
  }

  $user = getCurrentUser();

  if (empty($user) && empty(getSession('temp_user_id'))) {
    setTemporalUser();
  }

  $userid       = oneOf(@$user->id, getSession('temp_user_id'));
  $aid          = getRequestData('aid');
  $order        = getOrderByUserId($userid);
  $article      = getArticle($aid);

  if (!addToOrder($order, $article, $qty)) {
    $status->succeeded = false;
    $status->success   = null;
    $status->errors[]  = 'No se pudo actualizar el carrito';
    return $status;
  }

  loadCart();
  $status->success = "Se agregó <strong>$article->name</strong> al carrito";

  return $status;
}

function addToCart_checkIncommingData($qty)
{
  $status = newStatusObject();
  $aid    = getRequestData('aid');

  if (
    gettype($qty) != 'integer'
    && gettype($qty) != 'double'
  ) {
    $status->succeeded = false;
    $status->errors[]  = 'Quantity should be a number';
    return $status;
  }

  if (empty($aid)) {
    $status->succeeded = false;
    $status->errors[]  = 'Error al agregar el artículo al carrito';
    return $status;
  }

  if (!articleExists($aid)) {
    $status->succeeded = false;
    $status->errors[]  = 'El artículo que intentas agregar al carrito no existe';
    return $status;
  }

  $status->succeeded = true;

  return $status;
}

function setTemporalUser()
{
  $ipNumber     = (int) implode('', explode('.', getRealIP()));
  $timeLength   = time();
  $temp_user_id = $ipNumber + $timeLength;
  setSession('temp_user_id', $temp_user_id);
}

function getOrderByUserId($userid)
{
  $sql   = getOrderSqlGenerator($userid);
  $order = getDb()->getObject($sql);

  if (empty($order)) {
    $order = createNewOrder($userid);
  }

  return $order;
}

function getOrderSqlGenerator($userid)
{
  $fromTwoDaysAgo = time() - (2 * 24 * 60 * 60);
  $dateFromtwoDaysAgo = date('Y/m/d', $fromTwoDaysAgo);

  $sql = (
    "SELECT
      `id`,
      `date`,
      `total`,
      `status`
      FROM
        `orders`
      WHERE
        `user_id` = \"$userid\"
        AND `status` = 4
        AND `date` >= \"$dateFromtwoDaysAgo\""
  );

  return $sql;
}

function createNewOrder($userid) {
  $h         = "-3";
  $hm        = $h * 60;
  $ms        = $hm * 60;
  $gmdate    = gmdate("Y-m-d H:i:s", time() + ($ms));
  $sqlSelect = getOrderSqlGenerator($userid);
  $sqlInsert = (
    "INSERT
      INTO `orders` (
        `user_id`,
        `date`,
        `total`,
        `status`
      )
      VALUES (
        \"$userid\",
        \"$gmdate\",
        0,
        0,
        4
      )"
  );

  $orderId   = getDb()->insert($sqlInsert);
  $order     = getDb()->getObject($sqlSelect);

  return $order;
}

function getArticlePrice($article)
{
  return $article->oferta ? $article->precio_oferta : $article->precio;
}

function addToOrder($order, $article, $qty)
{
  $price           = getArticlePrice($article);
  $subtotal        = $price * $qty;
  $order->total    = $order->total + $subtotal;
  $order->quantity = $order->quantity + $qty;

  $sqlUpdate = (
    "UPDATE
      `orders`
      SET
        `total` = $order->total
      WHERE
        `id` = $order->id"
  );

  if (!getDB()->query($sqlUpdate)) {
    $order->total    = $order->total - $subtotal;
    $order->quantity = $order->quantity - $qty;
    return null;
  }

  $sqlInOrderArticle = (
    "SELECT
      `id`,
      `quantity`
      FROM
        `in_order_articles`
      WHERE
        `in_order_articles`.`article_id` = $article->id
        AND
        `in_order_articles`.`order_id` = $order->id"
  );

  $inOrderArticle = getDB()->getObject($sqlInOrderArticle);

  if (!empty($inOrderArticle)) {
    if (($inOrderArticle->quantity + $qty) > 0) {
      $sqlInsert = (
        "UPDATE
          `in_order_articles`
          SET
            `current_price` = $price,
            `quantity` = $inOrderArticle->quantity + $qty,
            `subtotal` = $price * ($inOrderArticle->quantity + $qty)
          WHERE
            `id` = $inOrderArticle->id"
      );
    } else {
      $sqlInsert = (
        "DELETE
          FROM
          `in_order_articles`
          WHERE
            `id` = $inOrderArticle->id"
      );
    }
  } else {
    $sqlInsert = (
      "INSERT
        INTO `in_order_articles` (
          `order_id`,
          `article_id`,
          `current_price`,
          `quantity`,
          `subtotal`
        )
        VALUES (
          $order->id,
          $article->id,
          $price,
          $qty,
          $subtotal
        )"
    );
  }

  $inOrderArticleId = getDB()->insert($sqlInsert);

  if (!isset($inOrderArticleId)) {
    return null;
  }

  return $order;
}

function getArticlesInOrder($oid)
{
  $sql = (
    "SELECT
      `in_order_articles`.`id`,
      `in_order_articles`.`article_id`,
      `in_order_articles`.`current_price`,
      `in_order_articles`.`quantity`,
      `in_order_articles`.`subtotal`,
      `articles`.`name`,
      `articles`.`code`,
      `articles`.`images_url`
      FROM `in_order_articles`
      JOIN `articles`
        ON `in_order_articles`.`article_id` = `articles`.`id`
      WHERE
        `in_order_articles`.`order_id` = $oid"
  );

  return getDB()->getObjects($sql);
}

function loadCart()
{
  $user   = getCurrentUser();
  $userid = oneOf(@$user->id, getSession('temp_user_id'));

  if (empty($userid)) {
    setSession('cart', null);
    return;
  }

  if (
    !empty(getSession('temp_user_id'))
    && !empty($user)
  ) {
    transferOrder(getSession('temp_user_id'), $user->id);
  }

  $sql   = getOrderSqlGenerator($userid);
  $order = getDb()->getObject($sql);

  if (empty($order)) {
    setSession('cart', null);
    return;
  }

  $cart = new stdClass();
  $cart->order    = $order;
  $cart->articles = getArticlesInOrder($order->id);

  setSession('cart', $cart);
}

function transferOrder($fromUser, $toUser)
{
  $sql   = getOrderSqlGenerator($fromUser);
  $order = getDb()->getObject($sql);

  if (empty($order)) {
    return;
  }

  $sqlUpdate = (
    "UPDATE
      `orders`
      SET
        `user_id` = $toUser
      WHERE
        `user_id` = $fromUser"
  );

  getDB()->query($sqlUpdate);
  return;
}

function saveOrderUserInfo() {
  /**
   * @TODO
   */
  $status = saveOrderUserInfo_checkIncomingData();

  if (!$status->succeeded) {
    return $status;
  }

  var_dump(getCurrentUser());
  var_dump(getCurrentCart());
  
  $sql = (
    ''
    // "UPDATE
    //   `orders`
    //   SET
    //     `current_price` = $price,
    //     `subtotal` = $price * ($inOrderArticle->quantity + $qty)
    //   WHERE
    //     `id` = $inOrderArticle->id"
  );

  return $status;
}

function saveOrderUserInfo_checkIncomingData() {
  $status = newStatusObject();

  if (!preg_match(REG_EXP_NAME_FORMAT, getRequestData('name'))) {
    $status->fieldsWithErrors['name'] = true;
    $status->errors[]                   = 'El nombre tiene un formato incorrecto. Tu nombre puede incluir letras, espacios y puntos';
  }

  if (!preg_match(REG_EXP_NAME_FORMAT, getRequestData('lastname'))) {
    $status->fieldsWithErrors['lastname'] = true;
    $status->errors[]                     = 'El apellido tiene un formato incorrecto. Tu nombre puede incluir letras, espacios y puntos';
  }

  if (empty(getRequestData('email'))) {
    $status->fieldsWithErrors['email'] = true;
    $status->errors[]                  = 'El email no puede ser vacío';
  } elseif (!preg_match(REG_EXP_EMAIL_FORMAT, getRequestData('email'))) {
    $status->fieldsWithErrors['email'] = true;
    $status->errors[]                  = 'El email no tiene el formato correcto';
  }

  if (empty(getRequestData('document'))) {
    $status->fieldsWithErrors['document'] = true;
    $status->errors[]                = 'Ingresa el RUT de tu empresa o tu número de documento';
  } elseif (!preg_match(REG_EXP_NUMBER_FORMAT, getRequestData(('document')))) {
    $status->fieldsWithErrors['document'] = true;
    $status->errors[]                = 'El RUT o número de documento no puede contener caracteres alfabéticos, puntos ni guiones, sólo números';
  }

  if (
    empty(getRequestData('phone'))
    && empty(getRequestData('cellphone'))
  ) {
    $status->fieldsWithErrors['phone'] = true;
    $status->fieldsWithErrors['cellphone']  = true;
    $status->errors[]                     = 'Debes ingresar al menos un número de teléfono, fijo o celular';
  } elseif (
    !empty(getRequestData('phone'))
    && !preg_match(REG_EXP_STRING_NUMBER_FORMAT, getRequestData('phone'))
  ) {
    $status->fieldsWithErrors['phone'] = true;
    $status->errors[]                     = 'El teléfono tiene un formato incorrecto. Puede incluir números, espacios y guiones';
  } elseif (
    !empty(getRequestData('cellphone'))
    && !preg_match(REG_EXP_STRING_NUMBER_FORMAT, getRequestData('cellphone'))
  ) {
    $status->fieldsWithErrors['cellphone'] = true;
    $status->errors[]                     = 'El celular tiene un formato incorrecto. Puede incluir números, espacios y guiones';
  }

  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }
  
  return $status;
}
