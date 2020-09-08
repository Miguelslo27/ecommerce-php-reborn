<?php

newDocument([
  'title' => 'eCommerce - Articulos',//change
  'page' => 'article',
  'components' => [
    'components/header/header',
    'components/lists/articles/article-details',
    'components/lists/articles/recently-added-articles',
    'components/lists/articles/featured-articles',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'components/lists/sidebar/sidebar.css',
    'components/lists/articles/article-details.css'
  ],
  'beforeRender' => function () {
    $currentCategory         = new stdClass();
    $currentCategory->title = 'Todos los artículos';
    $id = getServer('REQUEST_URI');
    $id = explode("=", $id);

    $where                 = '`status` = 1';
    $pager                 = getPager('articles', $where, ARTICLES_PER_PAGE);
    $articles              = getArticles($where, $pager->offset, $pager->per_page);
    $currentArticle        = getArticle($id[1]);
    $currentCategory       = getCategoryById($currentArticle->category_id);
    $mainCategory          = getCategoryById($currentCategory->category_id);
    $recentlyAddedArticles = getArticles('`status` = 1', 3, 3);
    $featuredArticles      = getArticles('`status` = 1', 0, 3);
    $categories            = getCategories('`category_id` = 0 AND `status` = 1');

    setGlobal('categories', oneOf($categories, []));
    setGlobal('recentlyAddedArticles', oneOf($recentlyAddedArticles, []));
    setGlobal('featuredArticles', oneOf($featuredArticles, []));
    setGlobal('currentCategory', $currentCategory);
    setGlobal('mainCategory', $mainCategory);
    setGlobal('categories', oneOf($categories, []));
    setGlobal('articles_pager', $pager);
    setGlobal('articles', oneOf($articles, []));
    setGlobal('currentArticle', $currentArticle);
  }
]);
