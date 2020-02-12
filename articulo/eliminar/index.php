<?php

$relative = '../../';
require '../../core/common.php';

newDocument('article', 'delete', [
  'components/admin/forms/delete-article'
], function ()
{
  protectFromNotAdminUsers();
});
