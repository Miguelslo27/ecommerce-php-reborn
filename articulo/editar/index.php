<?php

$relative = '../../';
require '../../core/common.php';

newDocument('article', 'edit', [
  'components/admin/forms/article'
], function ()
{
  protectFromNotAdminUsers();
});
