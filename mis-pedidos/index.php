<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'online-history';
$appSubPlace = '';

startDocument();
loadSection("header", $userStats);
loadSection("content", $userStats);
loadSection("footer", $userStats);
endDocument();

?>