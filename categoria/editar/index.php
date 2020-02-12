<?php

$relative = '../../';
require '../../core/common.php';

newDocument('category', 'edit', [
  'components/admin/forms/category'
], function ()
{
  protectFromNotAdminUsers();
});
