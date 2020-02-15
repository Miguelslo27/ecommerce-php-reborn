<?php

$relative = '../';
require_once '../core/common.php';

$userStats     = loadUser();
$page          = 'online-history';
$sub_page      = '';
$template_path = getTemplateAbsolutePath();

startDocument();
include($template_path . 'header.php');
include($template_path . 'content.php');
include($template_path . 'footer.php');
endDocument();

?>