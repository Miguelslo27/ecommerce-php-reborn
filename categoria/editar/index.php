<?php

$relative = '../../';
require_once '../../core/common.php';

newDocument('category', 'edit', [
  'components/admin/forms/category'
], function ()
{
  protectFromNotAdminUsers();
});
