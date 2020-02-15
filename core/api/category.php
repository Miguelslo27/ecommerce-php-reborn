<?php

/**
 * Get all active categories
 */
function getCategories($where = null, $offset = null, $perpage = null)
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
    FROM `categoria`"
  );

  if (isset($where)) {
    $sql .= " WHERE $where";
  }

  $sql .= " ORDER BY `orden` ASC";

  if (isset($offset) && isset($perpage)) {
    $sql .= " LIMIT $offset, $perpage";
  }

  return getDB()->getObjects($sql);
}

function getCategoriesByParentId($cid)
{}

function getCategoryById($cid)
{}
