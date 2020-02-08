<?php

$relative = '..';
require '../core/common.php';

$userStats = loadUser();
$appPlace = 'online-history';
$appSubPlace = '';

startDocument();
include($templatesPath . 'header.php');
include($templatesPath . 'content.php');
include($templatesPath . 'footer.php');
endDocument();

?>