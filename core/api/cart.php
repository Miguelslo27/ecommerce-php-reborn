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
        4
      )"
  );

  $orderId   = getDb()->insert($sqlInsert);
  $order     = getDb()->getObject($sqlSelect);

  return $order;
}

function getArticlePrice($article)
{
  return $article->offer ? $article->price_offer : $article->price;
}

function addToOrder($order, $article, $qty)
{
  $price           = getArticlePrice($article);
  $subtotal        = $price * $qty;

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

  if (($inOrderArticle->quantity + $qty) >= 0) {
    $subtotal = $price * $qty;
  } else {
    $subtotal = $price * ($inOrderArticle->quantity * -1);
  }
  $order->total = $order->total + $subtotal;
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

function saveOrderBillingInfo() {
  $status = saveOrderBillingInfo_checkIncomingData();

  if (!$status->succeeded) {
    return $status;
  }

  $orderid = getCurrentCart()->order->id;

  $sql = (
    "UPDATE
      `orders`
      SET
        `billing_name` = \"" . getPostData('billing_name') . "\",
        `billing_document` = \"" . getPostData('billing_document') . "\",
        `billing_address` = \"" . getPostData('billing_address') . "\",
        `billing_state` = \"" . getPostData('billing_state') . "\",
        `billing_city` = \"" . getPostData('billing_city') . "\",
        `billing_zipcode` = \"" . getPostData('billing_zipcode') . "\"
      WHERE
        `id` = $orderid"
  );

  if (!getDB()->query($sql)) {
    $status->succedded = false;
    $status->errors[]  = 'Error al guardar los datos, vuelve a intentar';
    return $status;
  }

  $status->success = 'Información de facturación guardada con éxito';

  return $status;
}

function saveOrderBillingInfo_checkIncomingData() {
  $status = newStatusObject();

  if (empty(getPostData('billing_name'))) {
    $status->fieldsWithErrors['billing_name'] = true;
    $status->errors[]                         = 'El nombre de la factura no puede ser vacío';
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('billing_name'))) {
    $status->fieldsWithErrors['billing_name'] = true;
    $status->errors[]                         = 'El nombre tiene un formato incorrecto. Tu nombre puede incluir letras, espacios y puntos';
  }

  if (empty(getPostData('billing_document'))) {
    $status->fieldsWithErrors['billing_document'] = true;
    $status->errors[]                             = 'Ingresa el RUT de tu empresa o tu número de documento';
  } elseif (!preg_match(REG_EXP_NUMBER_FORMAT, getPostData('billing_document'))) {
    $status->fieldsWithErrors['billing_document'] = true;
    $status->errors[]                             = 'El RUT o número de documento no puede contener caracteres alfabéticos, puntos ni guiones, sólo números';
  }

  if (empty(getPostData('billing_address'))) {
    $status->fieldsWithErrors['billing_address'] = true;
    $status->errors[]                            = 'La dirección de facturación es un campo requerido';
  } elseif (!preg_match(REG_EXP_STRING_FORMAT, getPostData('billing_address'))) {
    $status->fieldsWithErrors['billing_address'] = true;
    $status->errors[]                            = 'La dirección tiene un formato incorrecto, puede incluir letras, números y signos de puntuación';
  }

  if (empty(getPostData('billing_state'))) {
    $status->fieldsWithErrors['billing_state'] = true;
    $status->errors[]                          = 'El departamento es obligatorio';
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('billing_state'))) {
    $status->fieldsWithErrors['billing_state'] = true;
    $status->errors[]                          = 'El departamento tiene un formato incorrecto, puede incluir letras y signos de puntuación';
  }

  if (empty(getPostData('billing_city'))) {
    $status->fieldsWithErrors['billing_city'] = true;
    $status->errors[]                         = 'La localidad es obligatoria';
  } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('billing_city'))) {
    $status->fieldsWithErrors['billing_city'] = true;
    $status->errors[]                         = 'La localidad tiene un formato incorrecto, puede incluir letras y signos de puntuación';
  }

  if (
    !empty(getPostData('billing_zipcode'))
    && !preg_match(REG_EXP_NUMBER_FORMAT, getPostData('billing_zipcode'))
  ) {
    $status->fieldsWithErrors['billing_zipcode'] = true;
    $status->errors[]                            = 'El código postal tiene un formato incorrecto, debe contener sólo números.';
  }

  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }

  return $status;
}

function saveOrderShippingInfo()
{
  $status = saveOrderShippingInfo_checkIncomingData();

  if (!$status->succeeded) {
    return $status;
  }

  $orderid = getCurrentCart()->order->id;

  if (getPostData('shipping') === 'receive') {
    $shippingMethod = 1;
  } else {
    $shippingMethod = 0;
  }

  $sql = (
    "UPDATE
      `orders`
      SET
        `shipping_method` = \"" . $shippingMethod . "\",
        `shipping_address` = \"" . getPostData('shipping_address') . "\",
        `shipping_state` = \"" . getPostData('shipping_state') . "\",
        `shipping_city` = \"" . getPostData('shipping_city') . "\",
        `shipping_agency` = \"" . getPostData('shipping_agency') . "\",
        `shipping_zipcode` = \"" . getPostData('shipping_zipcode') . "\",
        `additional_comments` = \"" . getPostData('additional_notes') . "\"
      WHERE
        `id` = $orderid"
  );

  if (!getDB()->query($sql)) {
    $status->succedded = false;
    $status->errors[]  = 'Error al guardar los datos, vuelve a intentar';
    return $status;
  }

  $status->success = 'Información de envío guardada con éxito';

  return $status;
}

function saveOrderShippingInfo_checkIncomingData()
{
  $status = newStatusObject();

  if (
    getPostData('shipping') === 'receive'
    && empty(getPostData('copy-billing-address'))
  ) {
    if (empty(getPostData('shipping_address'))) {
      $status->fieldsWithErrors['shipping_address'] = true;
      $status->errors[]                             = 'La dirección de envío es un campo requerido';
    } elseif (!preg_match(REG_EXP_STRING_FORMAT, getPostData('shipping_address'))) {
      $status->fieldsWithErrors['shipping_address'] = true;
      $status->errors[]                             = 'La dirección tiene un formato incorrecto, puede incluir letras, números y signos de puntuación';
    }

    if (empty(getPostData('shipping_state'))) {
      $status->fieldsWithErrors['shipping_state'] = true;
      $status->errors[]                           = 'El departamento es obligatorio';
    } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('shipping_state'))) {
      $status->fieldsWithErrors['shipping_state'] = true;
      $status->errors[]                           = 'El departamento tiene un formato incorrecto, puede incluir letras y signos de puntuación';
    }

    if (empty(getPostData('shipping_city'))) {
      $status->fieldsWithErrors['shipping_city'] = true;
      $status->errors[]                          = 'La localidad es obligatoria';
    } elseif (!preg_match(REG_EXP_NAME_FORMAT, getPostData('shipping_city'))) {
      $status->fieldsWithErrors['shipping_city'] = true;
      $status->errors[]                          = 'La localidad tiene un formato incorrecto, puede incluir letras y signos de puntuación';
    }

    if (
      !empty(getPostData('shipping_zipcode'))
      && !preg_match(REG_EXP_NUMBER_FORMAT, getPostData('shipping_zipcode'))
    ) {
      $status->fieldsWithErrors['shipping_zipcode'] = true;
      $status->errors[]                             = 'El código postal tiene un formato incorrecto, debe contener sólo números.';
    }

    if (
      !empty(getPostData('shipping_agency'))
      && !preg_match(REG_EXP_NAME_FORMAT, getPostData('shipping_agency'))
    ) {
      $status->fieldsWithErrors['shipping_agency'] = true;
      $status->errors[]                            = 'La agencia tiene un formato incorrecto, puede incluir letras y signos de puntuación.';
    }
  }

  if (
    !empty(getPostData('additional_notes'))
    && !preg_match(REG_EXP_STRING_FORMAT, getPostData('additional_notes'))
  ) {
    $status->fieldsWithErrors['additional_notes'] = true;
    $status->errors[]                             = 'Las notas adicionales tienen un formato incorrecto, puede incluir letras, números y signos de puntuación.';
  }

  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }

  return $status;
}

function getOrderBillingInfo($oid)
{
  $sql = (
    "SELECT
      `billing_name`,
      `billing_document`,
      `billing_address`,
      `billing_state`,
      `billing_city`,
      `billing_zipcode`
      FROM `orders`
      WHERE `id` = $oid"
  );

  $order = getDB()->getObject($sql);

  return $order;
}

function getOrderShippingInfo($oid)
{
  $sql = (
    "SELECT
      `shipping_method`,
      `shipping_address`,
      `shipping_state`,
      `shipping_city`,
      `shipping_agency`,
      `shipping_zipcode`,
      `additional_comments`
      FROM `orders`
      WHERE `id` = $oid"
  );

  $order = getDB()->getObject($sql);

  return $order;
}
