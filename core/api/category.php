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

function getCategoryByTitle($title)
{
  return getCategories("`title` = '$title'");
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

function checkIfTitleExists($title)
{
  return getDB()->countOf('categories', "`title` = '$title'") > 0;
}

function restoreCategory()
{
  $cid = getRequestData('id');
  $status = newStatusObject();

  //UPDATE CATEGORY STATUS
  $sql = (
    "UPDATE
        `categories` 
      SET
        `status` = 1
      WHERE 
        `id` = $cid"
  );
  if(!getDB()->query($sql)) {
    $status->errors[] = 'La categoría no se puedo restaurar, intente de nuevo';
    return $status;
  }

  $status->succeeded = true;
  $status->success   = 'Categoría restaurada con éxito';
  return $status;
}

function removeCategory()
{
  $cid = getRequestData('id');
  $status = newStatusObject();

  //UPDATE CHILDREN CATEGORYS
  $children_cat = getCategoriesByParentId($cid);
  if (!empty($children_cat))
  {
    $sql = (
      "UPDATE
        `categories`
      SET 
        `category_id` = 0
      WHERE
        `category_id` = $cid"
    );

    if(!getDB()->query($sql)) {
      $status->errors[] = 'La categoría no se puedo eliminar, intente de nuevo';
      return $status;
    }
  }

  //UPDATE CATEGORY ARTICLES
  $category_articles =  getArticles("`category_id` = $cid");
  if (!empty($category_articles))
  {
    $sql = (
      "UPDATE
        `articles`
      SET 
        `category_id` = 0
      WHERE
        `category_id` = $cid"
    );

    if(!getDB()->query($sql)) {
      $status->errors[] = 'La categoría no se puedo eliminar, intente de nuevo';
      return $status;
    }
  }

  //REMOVE CATEGORY
  $sql = (
    "UPDATE
        `categories` 
      SET
        `status` = 0
      WHERE 
        `id` = $cid"
  );
  if(!getDB()->query($sql)) {
    $status->errors[] = 'La categoría no se puedo eliminar, intente de nuevo';
    return $status;
  }

  $status->succeeded = true;
  $status->success   = 'Categoría eliminada con éxito';
  return $status;
}

function handleCategory($action)
{
  $status = category_checkIncomingData($action);
  if (!$status->succeeded) {
    return $status;
  } 

  //DEFINE PARENT CATEGORY
  $parent_category = 0;
  if (!empty(getPostData('category_parent')) && getPostData('category_parent') !== 'no-category') {
    $parent_category = explode("+", getPostData('category_parent'));
    $parent_category = $parent_category[1];

    //IF THE PARENT CATEGORY IS ALSO A CHILD CATEGORY RETURN ERROR
    if (getCategoryById($parent_category)->category_id !== '0') {
      $status->succeeded = false;
      $status->errors    = ['Error, categoria padre inválida'];
      return $status;
    }
  }

  if ($action === 'edit') {
    $sql = (
      'UPDATE
        `categories`
      SET
        `title` = "' . getPostData('category_title') . '",
        `description` = "' . getPostData('category_description') . '",
        `brief_description` = "' . getPostData('category_brief_description') . '",
        `images_url` = "' . getPostData('category_img_url') . '",
        `category_id` = "' . $parent_category . '"
      WHERE
        `id` = "' . getPostData('category_id') . '"
      '
    );

    if(!getDB()->query($sql)) {
      $status->errors[] = 'Hubo un error al actualizar la categoría, inténtalo de nuevo';
      return $status;
    }
    $status->success = 'Categoría actualizada con éxito';

  } else if ($action === 'create') {
    $sql = (
        'INSERT
          INTO
            `categories`
            (
              `position`,
              `title`,
              `brief_description`,
              `description`,
              `category_id`,
              `images_url`
            )
          VALUES
            (
              "' . '0' . '",
              "' . getPostData('category_title') . '",
              "' . getPostData('category_brief_description') . '",
              "' . getPostData('category_description') . '",
              "' . $parent_category . '",
              "' . '' . '"
            )'
          );
      
    if(!getDB()->insert($sql)) {
      $status->errors = ['Hubo un error al crear la categoría, inténtalo de nuevo'];
    }
    $status->success = 'Categoría creada con éxito';
  }
  $status->succeeded = true;
  return $status;
}

function category_checkIncomingData($action)
{
  $status = newStatusObject();

  if (empty(getPostData('category_title'))) {
    $status->fieldsWithErrors['category_title'] = true;
    $status->errors[] = 'El titulo no puede ser vacío';
  }

  $sameCategory = ($action === 'create') ? false : getPostData('category_title') !== getCategoryById(getPostData('category_id'))->title;
  if ($action === 'create' || ($action === 'edit' && $sameCategory)) {
    if (checkIfTitleExists(getPostData('category_title'))) {
      if (getCategoryByTitle(getPostData('category_title'))[0]->status === '1') {
        $status->fieldsWithErrors['category_title'] = true;
        $status->errors[] = 'Ingrese un titulo diferente';
        return $status;
      } else {
        $status->fieldsWithErrors['category_title'] = true;
        $status->errors[] = 'El titulo pertenece a una categoría eliminada';
        return $status;
      }
    }
  }
  
  if (count($status->errors) == 0) {
    $status->succeeded = true;
  }

  return $status;
}