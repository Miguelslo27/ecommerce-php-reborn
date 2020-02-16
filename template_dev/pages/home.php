<?php

newDocument([
  'title' => 'eCommerce Demo App',
  'page' => 'home',
  'components' => [
    'components/header/header',
    'components/lists/categories/featured-categories',
    'components/lists/articles/recently-added-articles',
    'components/lists/articles/featured-articles',
    'components/footer/footer'
  ],
  'stylesheets' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css'
  ],
  'beforeRender' => function () {
    $featuredCategories    = getCategories('`estado` = 1', 0, 4);
    $recentlyAddedArticles = getArticles('`estado` = 1', 3, 3);
    $featuredArticles      = getArticles('`estado` = 1', 0, 3);

    setGlobal('featuredCategories', oneOf($featuredCategories, []));
    setGlobal('recentlyAddedArticles', oneOf($recentlyAddedArticles, []));
    setGlobal('featuredArticles', oneOf($featuredArticles, []));
  }
]);
