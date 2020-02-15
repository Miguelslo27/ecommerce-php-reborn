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
    'css/layout.css'
  ],
  'beforeRender' => function () {
    $featuredCategories    = getCategories('`estado` = 1', 0, 4);
    $recentlyAddedArticles = getArticles(3, 3);
    $featuredArticles      = getArticles(0, 3);

    setGlobal('featuredCategories', oneOf($featuredCategories, []));
    setGlobal('recentlyAddedArticles', oneOf($recentlyAddedArticles, []));
    setGlobal('featuredArticles', oneOf($featuredArticles, []));
  }
]);
