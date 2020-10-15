<?php

newDocument([
  'title' => 'eCommerce - Mi Carrito',
  'page' => 'cart',
  'components' => [
    'components/header/header',
    'components/cart/cart',
    'components/lists/articles/recently-added-articles',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/tables.css',
    'components/cart/cart-summary.css'
  ],
  'beforeRender' => function ()
  {
    $categories = getCategories('`category_id` = 0 AND `status` = 1');
    
    setGlobal('categories', oneOf($categories, []));
    setGlobal('recentlyAddedArticles', getArticles(null, 0, 3));
  }
]);
