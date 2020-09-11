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
    $key             = getQueryParamsByName(['clave'])['clave'];
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
      setGlobal('key', $key);
    }

    $categories = getCategories('`category_id` = 0 AND `status` = 1');
    setGlobal('categories', $categories);
  }
]);
