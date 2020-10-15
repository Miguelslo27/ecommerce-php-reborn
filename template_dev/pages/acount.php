<?php

newDocument([
  'title' => 'eCommerce - Mi Cuenta',
  'page' => 'account',
  'sub_page' => 'my_data',
  'components' => [
    'components/header/header',
    'components/account/account',
    'components/footer/footer'
  ],
  'styles' => [
    'css/fontawesome/css/all.min.css',
    'css/layout.css',
    'css/account.css',
    'css/forms.css'
  ],
  'beforeRender' => function () {
    $categories = getCategories('`category_id` = 0 AND `status` = 1');
    $userData = getCurrentUser();

    setGlobal('categories', oneOf($categories, []));
    setGlobal('user', $userData);
  }
]);