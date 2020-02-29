<?php

/**
 * Get all active categories
 */
function getArticles($where = null, $offset = null, $perpage = null)
{
  $sql = (
    "SELECT
      `id`,
      `nombre`,
      `codigo`,
      `descripcion_breve`,
      `descripcion`,
      `imagenes_url`,
      `categoria_id`,
      `nuevo`,
      `agotado`,
      `oferta`,
      `precio`,
      `precio_oferta`,
      `orden`
    FROM `articulo`"
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

function getArticle($aid)
{
  $sql = (
    "SELECT
      `id`,
      `nombre`,
      `codigo`,
      `descripcion_breve`,
      `descripcion`,
      `imagenes_url`,
      `categoria_id`,
      `nuevo`,
      `agotado`,
      `oferta`,
      `precio`,
      `precio_oferta`,
      `orden`
    FROM `articulo`
    WHERE `id` = $aid"
  );

  return getDB()->getObject($sql);
}

function articleExists($aid)
{
  $count = getDB()->countOf('articulo', "id = $aid");
  return $count > 0 ? true : false;
}
