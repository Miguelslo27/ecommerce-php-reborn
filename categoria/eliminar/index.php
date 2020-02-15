<?php

$relative = '../../';
require_once '../../core/common.php';

newDocument('category', 'delete', [
  'components/admin/forms/delete-category'
], function ()
{
  protectFromNotAdminUsers();
});
