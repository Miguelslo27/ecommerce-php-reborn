<?php

newDocument([
  'title' => 'eCommerce - Categoria',
  'page' => 'category',
  'components' => [
    'components/header/header',
    'components/category/category',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'components/lists/sidebar/sidebar.css'
  ],
  'beforeRender' => function () {
    $currentCategory = getCurrentCategory();
    
    if (empty($currentCategory)) {
      header('Location: 404');
      exit;
    }

    $currentSubCategories  = getCategories('`category_id` = ' . $currentCategory->id . ' AND `status` = 1');
    if ($currentSubCategories !== null) {
      $category_ids = [$currentCategory->id];
      foreach ($currentSubCategories as $subCategory => $value) {
        array_push($category_ids, $value->id);
      }
      $category_ids = implode(',', $category_ids);
    } else {
      $category_ids = $currentCategory->id;
    }  
    
    $where                = '`category_id` IN (' . $category_ids . ') AND `status` = 1';
    $pager                = getPager('articles', $where, ARTICLES_PER_PAGE);
    $articles             = getArticles($where, $pager->offset, $pager->per_page);
    $categories           = getCategories('`category_id` = 0 AND `status` = 1');    

    setGlobal('categories', oneOf($categories, []));
    setGlobal('currentCategory', $currentCategory);
    setGlobal('categoriesTotal', oneOf($categories, []));
    setGlobal('articles_pager', $pager);
    setGlobal('articles', oneOf($articles, []));
  }
]);
