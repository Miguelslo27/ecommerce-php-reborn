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
    $currentCategory->titulo = 'Todos los artículos';

    $categories = getCategories('`categoria_id` = 0 AND `estado` = 1');
    $where      = '`estado` = 1';
    $pager      = getPager('articulo', $where, ARTICLES_PER_PAGE);
    $articles   = getArticles($where, $pager->offset, $pager->per_page);

    setGlobal('currentCategory', $currentCategory);
    setGlobal('categories', oneOf($categories, []));
    setGlobal('articles_pager', $pager);
    setGlobal('articles', oneOf($articles, []));
  }
]);
