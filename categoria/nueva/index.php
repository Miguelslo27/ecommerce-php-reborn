<?php

$relative = '../../';
require_once '../../core/common.php';

newDocument('category', 'new', [
  'components/admin/forms/category'
], function ()
{
  protectFromNotAdminUsers();
});
