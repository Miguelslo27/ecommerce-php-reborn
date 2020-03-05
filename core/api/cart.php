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
  $status->success = "Se agregó <strong>$article->nombre</strong> al carrito";

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
      `fecha`,
      `total`,
      `cantidad`,
      `estado`
      FROM
        `pedido`
      WHERE
        `usuario_id` = \"$userid\"
        AND `estado` = 4
        AND `fecha` >= \"$dateFromtwoDaysAgo\""
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
      INTO `pedido` (
        `usuario_id`,
        `fecha`,
        `total`,
        `cantidad`,
        `estado`
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
  $order->cantidad = $order->cantidad + $qty;

  $sqlUpdate = (
    "UPDATE
      `pedido`
      SET
        `total` = $order->total,
        `cantidad` = $order->cantidad
      WHERE
        `id` = $order->id"
  );

  if (!getDB()->query($sqlUpdate)) {
    $order->total    = $order->total - $subtotal;
    $order->cantidad = $order->cantidad - $qty;
    return null;
  }

  $sqlInOrderArticle = (
    "SELECT
      `id`,
      `cantidad`
      FROM
        `articulo_pedido`
      WHERE
        `articulo_pedido`.`articulo_id` = $article->id
        AND
        `articulo_pedido`.`pedido_id` = $order->id"
  );

  $inOrderArticle = getDB()->getObject($sqlInOrderArticle);

  if (!empty($inOrderArticle)) {
    $sqlInsert = (
      "UPDATE
        `articulo_pedido`
        SET
          `precio_actual` = $price,
          `cantidad` = $inOrderArticle->cantidad + $qty,
          `subtotal` = $price * ($inOrderArticle->cantidad + $qty)
        WHERE
          `id` = $inOrderArticle->id"
    );
  } else {
    $sqlInsert = (
      "INSERT
        INTO `articulo_pedido` (
          `pedido_id`,
          `articulo_id`,
          `precio_actual`,
          `cantidad`,
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
      `articulo_pedido`.`id`,
      `articulo_pedido`.`articulo_id`,
      `articulo_pedido`.`precio_actual`,
      `articulo_pedido`.`cantidad`,
      `articulo_pedido`.`subtotal`,
      `articulo`.`nombre`,
      `articulo`.`codigo`,
      `articulo`.`imagenes_url`
      FROM `articulo_pedido`
      JOIN `articulo`
        ON `articulo_pedido`.`articulo_id` = `articulo`.`id`
      WHERE
        `articulo_pedido`.`pedido_id` = $oid"
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
      `pedido`
      SET
        `usuario_id` = $toUser
      WHERE
        `usuario_id` = $fromUser"
  );

  getDB()->query($sqlUpdate);
  return;
}