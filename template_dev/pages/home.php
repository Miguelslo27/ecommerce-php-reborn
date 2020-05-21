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
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css'
  ],
  'beforeRender' => function ()
  {
    $categories            = getCategories();
    $featuredCategories    = getCategories('`status` = 1', 0, 4);
    $recentlyAddedArticles = getArticles('`status` = 1', 3, 3);
    $featuredArticles      = getArticles('`status` = 1', 0, 3);
    $categories            = getCategories();
    
    setGlobal('categories', oneOf($categories, []));
    setGlobal('categories', oneOf($categories, []));
    setGlobal('featuredCategories', oneOf($featuredCategories, []));
    setGlobal('recentlyAddedArticles', oneOf($recentlyAddedArticles, []));
    setGlobal('featuredArticles', oneOf($featuredArticles, []));
  },
  'afterRender' => function ()
  {
    if (!empty(getSession('request_messages'))) {
      setSession('request_messages', null);
    }
  }
]);
