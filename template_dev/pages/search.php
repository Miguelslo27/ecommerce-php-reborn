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

    $categories = getCategories('`category_id` = 0 AND `status` = 1');
    $where      = '`status` = 1';
    $pager      = getPager('articles', $where, ARTICLES_PER_PAGE);
    $articles   = getArticles($where, $pager->offset, $pager->per_page);

    setGlobal('key', $key[1]);
    setGlobal('categories', oneOf($categories, []));
    setGlobal('articles_pager', $pager);
    setGlobal('articles', oneOf($articles, []));
  }
]);
