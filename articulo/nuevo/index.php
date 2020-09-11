<?php

$relative = '../../';
require_once '../../core/common.php';

newDocument('article', 'new', [
  'components/admin/forms/article'
], function ()
{
  protectFromNotAdminUsers();
});
