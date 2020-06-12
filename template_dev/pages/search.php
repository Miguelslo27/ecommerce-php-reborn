<?php

newDocument([
  'title' => 'Resultados de la búsqueda - eCommerce',
  'page' => 'search',
  'components' => [
    'components/header/header',
    'components/lists/search/search',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/forms.css',
    'components/lists/sidebar/sidebar.css',
    'components/category/category.css'
  ],
  'beforeRender' => function () {
    $key = getServer('REQUEST_URI');
    $key = explode("=", $key);
    
    if($key[0] != '/busqueda/?clave')
    {
      @$key = ($key[3]);
    }
    else
    {
      $key = ($key[1]);
    }

    $key = str_replace("+", " ", $key);
    
    $result_articles = searchArticle($key);
    
    if($result_articles != null)
    {
      $articles_id    = array_map("returnId", $result_articles);
      $count_articles = count($articles_id);
      $articles_id    = implode(',', $articles_id);
      $where          = "`id` IN ($articles_id)";
      $pager          = getPager('articles', $where, ARTICLES_PER_PAGE);
      $articles       = getArticles($where, $pager->offset, $pager->per_page);

      setGlobal('count_articles', $count_articles);
      setGlobal('articles', oneOf($articles, []));
      setGlobal('articles_pager', $pager);
    }

    $categories      = getCategories('`category_id` = 0 AND `status` = 1');
    setGlobal('categories', oneOf($categories, []));
    setGlobal('key', $key);

    logToConsole('$result_articles', $result_articles, __FILE__, __FUNCTION__, __LINE__);
    logToConsole('pager', $key, __FILE__, __FUNCTION__, __LINE__);
  }
]);
