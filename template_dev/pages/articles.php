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
    $currentCategory->title  = 'Todos los artículos';

    $categoriesArticles      = getCategories('`category_id` = 0 AND `status` = 1');
    $where                   = '`status` = 1';
    $pager                   = getPager('articles', $where, ARTICLES_PER_PAGE);
    $articles                = getArticles($where, $pager->offset, $pager->per_page);
    $categories              = getCategories('`category_id` = 0 AND `status` = 1');

    setGlobal('categories', oneOf($categories, []));
    setGlobal('currentCategory', $currentCategory);
    setGlobal('categoriesArticles', oneOf($categoriesArticles, []));
    setGlobal('articles_pager', $pager);
    setGlobal('articles', oneOf($articles, []));
  }
]);
