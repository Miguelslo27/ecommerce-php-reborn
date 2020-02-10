<?php

$relative = '../../../';
require '../../../core/common.php';
header('Content-type: application/json');

echo JSON_encode(completarPedido($_GET['id']));

?>