<?php

$relative = '../';
require '../core/common.php';

newDocument('articles', 'list', [
  'components/articles/articles'
], function () {
  setGlobal('categories', getCategories(0));
  setGlobal('articles', getArticles());
});
