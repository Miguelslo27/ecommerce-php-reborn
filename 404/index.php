<?php

$relative = '../';
require '../core/common.php';

$userStats     = loadUser();
$page          = '404';
$sub_page      = '';
$template_path = getTemplatePath();

startDocument();
include($template_path . 'header.php');
include($template_path . 'pages/404.php');
include($template_path . 'footer.php');
endDocument();

?>
