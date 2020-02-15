<?php

newDocument([
  'title' => 'eCommerce - Categorias',
  'page' => 'categories',
  'components' => [
    'components/header/header',
    'components/lists/categories/categories',
    'components/footer/footer'
  ],
  'stylesheets' => [
    'css/layout.css'
  ],
  'beforeRender' => function () {
    $pager      = getPagination('categoria', '`estado` = 1', CATEGORIES_PER_PAGE);
    $categories = getCategories('`estado` = 1', $pager->offset, $pager->per_page);

    setGlobal('categories_pager', $pager);
    setGlobal('categories', oneOf($categories, []));
  }
]);
