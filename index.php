<?php

require_once './core/core.php';

newDocument([
  'title' => 'eCommerce Demo App',
  'page' => 'home',
  'components' => [
    'components/header/header',
    'components/lists/categories/featured-categories',
    'components/lists/articles/featured-articles',
    'components/lists/articles/recently-added-articles',
    'components/footer/footer'
  ],
  'stylesheets' => [
    'css/layout.css'
  ],
  'callbefore' => function () {
    $featuredCategories    = getCategories(0, 2);
    $featuredArticles      = getArticles(0, 3);
    $recentlyAddedArticles = getArticles(3, 3);

    setGlobal('featuredCategories', oneOf($featuredCategories, []));
    setGlobal('featuredArticles', oneOf($featuredArticles, []));
    setGlobal('recentlyAddedArticles', oneOf($recentlyAddedArticles, []));
  }
]);
