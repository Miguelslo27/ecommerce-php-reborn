<?php

/**
 * Get all active categories
 */
function getCategories($where = null, $offset = null, $perpage = null)
{
  $sql = (
    'SELECT
      `id`,
      `titulo`,
      `descripcion_breve`,
      `descripcion`,
      `imagen_url`,
      `categoria_id`,
      `estado`,
      `orden`
    FROM `categoria`'
  );

  if (isset($where)) {
    $sql .= " WHERE $where";
  }

  $sql .= ' ORDER BY `orden` ASC';

  if (isset($offset) && isset($perpage)) {
    $sql .= " LIMIT $offset, $perpage";
  }

  return getDB()->getObjects($sql);
}

function getCategoriesByParentId($cid)
{
  return getCategories("`categoria_id` = '$cid'");
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
      `titulo`,
      `descripcion_breve`,
      `descripcion`,
      `imagen_url`,
      `categoria_id`,
      `estado`,
      `orden`
    FROM `categoria`
    WHERE `id` = $cid"
  );

  return getDB()->getObject($sql);
}
