<?php

newDocument([
  'title' => 'eCommerce - Categorias',
  'page' => 'categories',
  'components' => [
    'components/header/header',
    'components/lists/categories/categories',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css'
  ],
  'beforeRender' => function () {
    $where      = '`category_id` = 0 AND `status` = 1';
    $pager      = getPager('categories', $where, CATEGORIES_PER_PAGE);
    $categories = getCategories($where, $pager->offset, $pager->per_page);

    setGlobal('categories_pager', $pager);
    setGlobal('categories', oneOf($categories, []));
  }
]);
