<?php

$relative = '../../';
require_once '../../core/common.php';

newDocument('article', 'delete', [
  'components/admin/forms/delete-article'
], function ()
{
  protectFromNotAdminUsers();
});
