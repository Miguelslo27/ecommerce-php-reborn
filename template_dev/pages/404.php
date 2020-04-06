<?php

newDocument([
  'title' => 'Página no encontrada',
  'page' => 'not-found',
  'components' => [
    'components/header/header',
    'components/not-found-content/not-found-content',
    'components/lists/categories/featured-categories',
    'components/lists/articles/recently-added-articles',
    'components/lists/articles/featured-articles',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'components/not-found-content/not-found-content.css',
    'css/layout.css'
  ],
  'beforeRender' => function ()
  {
    $featuredCategories    = getCategories('`status` = 1', 0, 4);
    $recentlyAddedArticles = getArticles('`status` = 1', 3, 3);
    $featuredArticles      = getArticles('`status` = 1', 0, 3);

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
