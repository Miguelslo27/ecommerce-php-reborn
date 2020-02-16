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
    'css/layout.css'
  ],
  'beforeRender' => function () {
    $currentCategory = getCurrentCategory();
    $articles        = getArticles();
    
    if (empty($currentCategory)) {
      header('Location: 404');
      exit;
    }
    
    setGlobal('currentCategory', $currentCategory);
    setGlobal('articles', $articles);
  }
]);
