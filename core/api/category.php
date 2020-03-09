<?php

/**
 * Get all active categories
 */
function getCategories($where = null, $offset = null, $perpage = null)
{
  $sql = (
    'SELECT
      `id`,
      `title`,
      `brief_description`,
      `description`,
      `images_url`,
      `category_id`,
      `status`,
      `position`
    FROM `categories`'
  );

  if (isset($where)) {
    $sql .= " WHERE $where";
  }

  $sql .= ' ORDER BY `position` ASC';

  if (isset($offset) && isset($perpage)) {
    $sql .= " LIMIT $offset, $perpage";
  }

  return getDB()->getObjects($sql);
}

function getCategoriesByParentId($cid)
{
  return getCategories("`category_id` = '$cid'");
}

function getCurrentCategory()
{
  return getCategoryById(getGetData('cid'));
}

function getCategoryById($cid)
{
  $sql = (
    "SELECT
      `id`,
      `title`,
      `brief_description`,
      `description`,
      `images_url`,
      `category_id`,
      `status`,
      `position`
    FROM `categories`
    WHERE `id` = $cid"
  );

  return getDB()->getObject($sql);
}
