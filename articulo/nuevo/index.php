<?php

$relative = '../../';
require '../../core/common.php';

newDocument('article', 'new', [
  'components/admin/forms/article'
], function ()
{
  protectFromNotAdminUsers();
});
