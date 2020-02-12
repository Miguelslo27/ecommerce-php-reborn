<?php

$relative = '../../';
require '../../core/common.php';

newDocument('category', 'new', [
  'components/admin/forms/category'
], function ()
{
  protectFromNotAdminUsers();
});
