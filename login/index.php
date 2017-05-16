<?php

$relative = '..';
require '../includes/common.php';

$userStats = loginUser();
$appPlace = 'home';
$appSubPlace = 'login';

startDocument();
loadSection("header", $userStats);
loadSection("content", $userStats);
loadSection("footer", $userStats);
endDocument();

?>