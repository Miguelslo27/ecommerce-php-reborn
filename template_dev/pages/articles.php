<?php

newDocument([
  'title' => 'eCommerce - Articulos',
  'page' => 'articles',
  'components' => [
    'components/header/header',
    'components/category/category',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'components/lists/sidebar/sidebar.css'
  ],
  'beforeRender' => function () {
    $currentCategory         = new stdClass();
    $currentCategory->title = 'Todos los artículos';

    $categories = getCategories('`category_id` = 0 AND `status` = 1');
    $where      = '`status` = 1';
    $pager      = getPager('articles', $where, ARTICLES_PER_PAGE);
    $articles   = getArticles($where, $pager->offset, $pager->per_page);

    setGlobal('currentCategory', $currentCategory);
    setGlobal('categories', oneOf($categories, []));
    setGlobal('articles_pager', $pager);
    setGlobal('articles', oneOf($articles, []));
  }
]);
