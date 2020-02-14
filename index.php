<?php

require_once './core/core.php';

newDocument([
  'title' => 'eCommerce Demo App',
  'page' => 'home',
  'components' => [
    'components/header/header',
    'components/lists/categories/categories',
    'components/footer/footer'
  ],
  'stylesheets' => [
    'css/layout.css'
  ],
  'callbefore' => function () {
    setGlobal('categories', []);
  },
  'scripts' => []
]);
