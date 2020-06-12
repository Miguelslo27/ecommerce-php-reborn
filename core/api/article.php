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
//str_replace // %key%%key%
function returnId($var) {
  return $var->id;
}
