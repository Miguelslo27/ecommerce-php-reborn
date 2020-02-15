<?php

$relative = '../../';
require_once '../../core/common.php';

newDocument('article', 'edit', [
  'components/admin/forms/article'
], function ()
{
  protectFromNotAdminUsers();
});
