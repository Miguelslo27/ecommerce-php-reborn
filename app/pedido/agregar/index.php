<?php

$relative = '../../../';
require_once '../../../core/common.php';
header('Content-type: application/json');

echo JSON_encode(addToCart($_GET['id'], $_GET['c'], $_GET['p'], @$_GET['t'], @$_GET['color']));

?>