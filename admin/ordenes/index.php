<?php

$relative = '../../';
require_once '../../core/common.php';

newDocument('admin', 'orders', [
  'components/admin/collections/orders',
], function ()
{
  protectFromNotAdminUsers();
  setGlobal('users', getUsers());
});
