<?php

$relative = '../';
require '../core/common.php';

$userStats     = loadUser();
$page          = 'online-history';
$sub_page      = '';
$template_path = getTemplatePath();

startDocument();
include($template_path . 'header.php');
include($template_path . 'content.php');
include($template_path . 'footer.php');
endDocument();

?>