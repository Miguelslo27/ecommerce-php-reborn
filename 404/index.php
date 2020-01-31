<?php

$relative = '..';
include('../includes/common.php');

$userStats = loadUser();
$appPlace = '404';
$appSubPlace = '';
$templatesPath = $GLOBALS['config']['templatesPath'];

startDocument();
loadSection("header", $userStats);

include($templatesPath . 'pages/404.php');

loadSection("footer", $userStats);
endDocument();
?>