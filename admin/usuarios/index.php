<?php

$relative = '../../';
require_once '../../core/common.php';

newDocument('admin', 'users', [
  'components/admin/collections/users',
], function ()
{
  protectFromNotAdminUsers();
  setGlobal('users', getUsers());
});
