<?php

$relative = '../';
require '../core/common.php';

newDocument('categories', 'list', [
  'components/categories/categories'
], function () {
  setGlobal('categories', getCategories(0));
});
