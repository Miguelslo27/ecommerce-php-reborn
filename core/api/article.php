<?php

/**
 * Get all active categories
 */
function getArticles($where = null, $offset = null, $perpage = null)
{
  $sql = (
    "SELECT
      `id`,
      `name`,
      `code`,
      `brief_description`,
      `description`,
      `images_url`,
      `category_id`,
      `new`,
      `spent`,
      `offer`,
      `price`,
      `price_offer`,
      `position`
    FROM `articles`"
  );

  if (isset($where)) {
    $sql .= " WHERE $where";
  }

  $sql .= " ORDER BY `position` ASC";

  if (isset($offset) && isset($perpage)) {
    $sql .= " LIMIT $offset, $perpage";
  }

  return getDB()->getObjects($sql);
}

function getArticle($aid)
{
  $sql = (
    "SELECT
      `id`,
      `name`,
      `code`,
      `brief_description`,
      `description`,
      `images_url`,
      `category_id`,
      `new`,
      `spent`,
      `offer`,
      `price`,
      `price_offer`,
      `position`
    FROM `articles`
    WHERE `id` = $aid"
  );

  return getDB()->getObject($sql);
}

function articleExists($aid)
{
  $count = getDB()->countOf('articles', "id = $aid");
  return $count > 0 ? true : false;
}

function searchArticle($key)
{
  $key = str_replace(" ", "%", $key);

  $sql = (
    "SELECT
      `id`
    FROM `articles`
    WHERE `name` LIKE '%$key%'
    OR `code` LIKE '%$key%'
    OR `brief_description` LIKE '%$key%'
    OR `description` LIKE '%$key%'"
  );

  return getDB()->getObjects($sql);
}

function returnId($var) {
  return $var->id;
}

function handleArticle()
{
  $status = article_checkIncomingData();
  if (!$status->succeeded) {
    return $status;
  } 

  $parent_category = 0;
  if (!empty(getPostData('article_category')) && getPostData('article_category') !== 'no-category') {
    $parent_category = explode("+", getPostData('article_category'));
    $parent_category = $parent_category[1];
  }

  $sql = (
    'INSERT
      INTO
        `articles`
        (
          `position`,
          `name`,
          `code`,
          `brief_description`,
          `description`,
          `price`,
          `price_offer`,
          `category_id`,
          `new`,
          `spent`,
          `offer`,
          `images_url`,
          `status`
        )
      VALUES
        (
          "' . '0' . '",
          "' . getPostData('article_name') . '",
          "' . getPostData('article_code') . '",
          "' . getPostData('article_brief_description') . '",
          "' . getPostData('article_description') . '",
          "' . getPostData('article_price') . '",
          "' . (!empty(getPostData('article_offer')) ? getPostData('article_price_offer') : '0') . '",
          "' . $parent_category . '",
          "' . (!empty(getPostData('article_new')) ? '1' : '0') . '",
          "' . (!empty(getPostData('article_spent')) ? '1' : '0') . '",
          "' . (!empty(getPostData('article_offer')) ? '1' : '0') . '",
          "' . getPostData('article_img_url') . '",
          "' . '1' . '"
        )'
      );
  
  if(!getDB()->insert($sql)) {
    $status->succeeded = false;
    $status->errors = ['Hubo un error al crear el articulo, inténtalo de nuevo'];
  } else {
    $status->success = 'Articulo creado con éxito';
    $status->succeeded = true;
  }

  return $status;
}

function article_checkIncomingData()
{
  $status = newStatusObject();

  if (empty(getPostData('article_name'))) {
    $status->fieldsWithErrors['article_name'] = true;
    $status->errors[] = 'El nombre del articulo no puede ser vacío';
  }

  if (empty(getPostData('article_code'))) {
    $status->fieldsWithErrors['article_code'] = true;
    $status->errors[] = 'El código del articulo no puede ser vacío';
  }

  if (empty(getPostData('article_price'))) {
    $status->fieldsWithErrors['article_price'] = true;
    $status->errors[] = 'El precio del articulo no puede ser vacío';
  }

  if (empty(getPostData('article_brief_description'))) {
    $status->fieldsWithErrors['article_brief_description'] = true;
    $status->errors[] = 'La descripción breve del articulo no puede ser vacía';
  }

  if (!empty(getPostData('article_offer')) && empty(getPostData('article_price_offer'))) {
    $status->fieldsWithErrors['article_price_offer'] = true;
    $status->errors[] = 'El precio de oferta del articulo no puede ser vacío si la casilla de oferta esta seleccionada';
  }

  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }

  return $status;
}

function restoreArticle()
{
  $article_id = getRequestData('id');
  $status = newStatusObject();

  $sql = (
    "UPDATE 
        `articles`
      SET
        `status` = 1
      WHERE
        `id` = $article_id"
  );

  if (!getDB()->query($sql)) {
    $status->errors[] = 'El artículo no se puedo restaurar, intente de nuevo';
    return $status;
  }

  $status->succeeded = true;
  $status->success   = "Artículo restaurado con éxito";
  return $status;
}
