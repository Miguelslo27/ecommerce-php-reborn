<?php

$relative = '..';
include('../core/common.php');

$userStats = loadUser();
$appPlace = '404';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
include($templatesPath . 'header.php');

include($templatesPath . 'pages/404.php');

include($templatesPath . 'footer.php');
endDocument();
?>