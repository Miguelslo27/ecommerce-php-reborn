<?php

$relative = '../';
require '../core/common.php';

newDocument('404', null, [
  'pages/404',
  'components/forms/search',
  'components/categories/featuredCategories',
  'components/articles/featuredArticles'
]);
