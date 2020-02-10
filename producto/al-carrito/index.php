<?php

$relative = '../../';
require '../../core/common.php';

$articleId = $_GET['id'];
$quantity  = $_GET['q'];

addToCart($articleId, $quantity);
header('Location: ' . $_SERVER['HTTP_REFERER']);
