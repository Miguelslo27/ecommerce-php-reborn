<?php

$relative = '';
require_once('core/common.php');

newDocument('home', '', array(
  'components/hero',
  'components/categories/featuredCategories',
  'components/articles/newArticles',
  'components/articles/featuredArticles'
));
