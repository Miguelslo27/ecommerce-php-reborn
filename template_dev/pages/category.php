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
    $articles   = getArticles();

    setGlobal('currentCategory', $currentCategory);
    setGlobal('categories', $categories);
    setGlobal('articles', $articles);
  }
]);
