<?php

newDocument([
  'title' => 'eCommerce - Categoria',
  'page' => 'category',
  'components' => [
    'components/header/header',
    'components/category/category',
    'components/footer/footer'
  ],
  'stylesheets' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'components/lists/sidebar/sidebar.css'
  ],
  'beforeRender' => function () {
    $currentCategory = getCurrentCategory();
    
    if (empty($currentCategory)) {
      header('Location: 404');
      exit;
    }

    $categories = getCategories('`categoria_id` = 0 AND `estado` = 1');
    $where      = '`categoria_id` = ' . $currentCategory->id . ' AND `estado` = 1';
    $pager      = getPager('articulo', $where, ARTICLES_PER_PAGE);
    $articles   = getArticles($where, $pager->offset, $pager->per_page);

    setGlobal('currentCategory', $currentCategory);
    setGlobal('categories', oneOf($categories, []));
    setGlobal('articles_pager', $pager);
    setGlobal('articles', oneOf($articles, []));
  }
]);
